<main class="main_secciones" style="background-color: <?php echo $color; ?>;">
    <form class="formulario" action='registro' method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre">
        <br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido">
        <br><br>

        <label for="user">Usuario:</label>
        <input type="text" name="user">
        <br><br>

        <label for="email">Email:</label>
        <input type="text" name="email">
        <br><br>

        <label for="contrasena">Contraseña</label>
        <input type="text" name="contrasena">
        <br><br>

        <input type="submit" name="enviar" value="Enviar">
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
        $nombre = filtrado($_POST["nombre"]);
        $apellido = filtrado($_POST["apellido"]);
        $user = filtrado($_POST["user"]);
        $email = filtrado($_POST["email"]);
        $contrasena = filtrado($_POST["contrasena"]);
        $errorNum = 0;
        $roles = ["usuario", "admin"];

        if (empty($nombre) || !preg_match('/^[a-zA-Z]{1,20}$/', $nombre)) {
            $errorNum++;
            $errores[] = "El nombre no cumple el formato correcto.";
        } else {
            $nombre = strtolower($nombre);
            $nombre = ucfirst($nombre);
        }

        if (empty($apellido) || !preg_match('/^[a-zA-Z]+$/', $apellido)) {
            $errorNum++;
            $errores[] = "El apellido no cumple el formato correcto.";
        } else {
            $apellido = strtolower($apellido);
            $apellido = ucfirst($apellido);
        }

        if (empty($user) || !preg_match('/^[a-zA-Z0-9]{1,20}$/', $user)) {
            $errorNum++;
            $errores[] = "El nombre de usuario no cumple el formato correcto.";
        }

        if (empty($email) || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            $errorNum++;
            $errores[] = "El email no cumple el formato correcto";
        }

        if (empty($contrasena) || !preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+?]).{8,}$/', $contrasena)) {
            $errorNum++;
            $errores[] = "La contraseña no cumple el formado correcto";
        } else {
            $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        }

        if ($errorNum != 0) {
            foreach ($errores as $error) {
                echo ("<p class=error><br>$error</p>");
            }
        } else {
            $fichero = ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "usuarios.json";

            $contenido = file_get_contents($fichero);

            $usuarios = json_decode($contenido, true);

            $rol = $roles[array_rand($roles)];
            $nuevoUsuario = ["nombre" => $nombre, "apellido" => $apellido, "nombreUser" => $user, "email" => $email, "rol" => $rol, "contrasena" => $contrasena];

            $repetido = false;
            foreach ($usuarios as $usuario) {
                if ($usuario["nombreUser"] == $nuevoUsuario["nombreUser"]) {
                    echo "El nombre de usuario ya esta utilizado, intentelo de nuevo";
                    $repetido = true;
                }
            }

            if ($repetido == false) {
                $usuarios[] = $nuevoUsuario;

                $usuariosJSON = json_encode($usuarios, JSON_PRETTY_PRINT);

                if (file_put_contents($fichero, $usuariosJSON)) {
                    echo "Datos guardados correctamente";
                } else {
                    echo "Error al guardar los datos";
                }
            }
        }
    }
    ?>
</main>