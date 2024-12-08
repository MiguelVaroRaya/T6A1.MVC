<main class="main_secciones" style="background-color: <?php

use App\Models\UsuarioModel;

 echo $color; ?>;">
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

        <label for="fecha">Fecha de Nacimiento:</label>
        <input type="date" name="fecha">
        <br><br>

        <label for="saldo">Saldo:</label>
        <input type="number" name="saldo">
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
        $fecha = filtrado($_POST["fecha"]);
        $saldo = filtrado($_POST["saldo"]);
        $contrasena = filtrado($_POST["contrasena"]);
        $errorNum = 0;

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

        if (empty($fecha) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha) || !strtotime($fecha)) {
            $errorNum++;
            $errores[] = "La fecha no cumple el formato correcto";
        }

        if (empty($saldo) || !preg_match('/^[0-9]+$/', $saldo)) {
            $errorNum++;
            $errores[] = "El saldo no cumple el formato correcto";
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
            $usuarioModel = new UsuarioModel();
            $usuarioModel -> create(["nombre" => $nombre, "apellidos" => $apellido, "nombre_usuario" => $user, "email" => $email, "fecha_nacimiento" => $fecha, "password" => $contrasena, "saldo" => $saldo]);
        }
    }
    ?>
</main>