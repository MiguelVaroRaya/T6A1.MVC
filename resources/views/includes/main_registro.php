<?php

use App\Models\UsuarioModel;

?>

<main class="main_secciones">
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

        <label for="contrasena">Contraseña:</label>
        <input type="text" name="contrasena">
        <br><br>

        <input type="submit" name="enviar" value="Enviar">
    </form>

    <?php

    if (count($data)) {
        foreach ($data as $key => $error) {
            echo ("<p class=error><br>$error</p>");
        }
    }
    ?>
</main>