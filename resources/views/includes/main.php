<?php

$color = isset($_COOKIE['colorMain']) ? $_COOKIE['colorMain'] : '#ebeeee';
?>

<main class="main_secciones" style="background-color: <?php echo $color; ?>;">
    <form class="formulario" action='inicioSesion' method="post">
        <label for="user">Usuario</label>
        <input type="text" name="user">
        <label for="password">Contraseña</label>
        <input type="text" name="password">
        <input type="submit" name="enviar" value="Iniciar Sesión">
    </form>

    <form class="formulario" action='registro' method="post">
        <input type="submit" name="registro" value="Registrarse" id="boton_registro">
    </form>

    <?php

    function filtrado(string $datos): string
    {
        $datos = trim($datos); // Elimina espacios antes y después de los datos 
        $datos = stripslashes($datos); // Elimina backslashes \ 
        $datos = htmlspecialchars($datos);  // Traduce caracteres especiales en entidades HTML 
        return $datos;
    }

    if (isset($_POST["enviar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $user = filtrado($_POST["user"]);
        $password = filtrado($_POST["password"]);
        $errorNum = 0;

        if (empty($user) || !preg_match('/^[a-zA-Z0-9]{1,20}$/', $user)) {
            $errorNum++;
            $errores[] = "Usuario inválido";
        }

        if (empty($password) || !preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+?]).{8,}$/', $password)) {
            $errorNum++;
            $errores[] = "Contraseña inválida";
        }

        if ($errorNum != 0) {
            foreach ($errores as $error) {
                echo ("<p class=error><br>$error</p>");
            }
        } else {
            $fichero = ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "usuarios.json";

            $contenido = file_get_contents($fichero);

            $usuarios = json_decode($contenido, true);

            foreach ($usuarios as $usuario) {
                if ($usuario["nombreUser"] == $user) {
                    if (password_verify($password, $usuario["contrasena"])) {
                        $_SESSION["user"] = $usuario["nombreUser"];
                        $_SESSION["nombre"] = $usuario["nombre"];
                        $_SESSION["rol"] = $usuario["rol"];
                        $_SESSION["timeout"] = time();
                        $_SESSION["inactividad"] = 240;
                        header("location: /");
                    }
                }
            }

            if (!isset($_SESSION["nombre"])) {
                echo ("<p class=error>Datos incorrectos</p>");
            }
        }
    }
    ?>
</main>