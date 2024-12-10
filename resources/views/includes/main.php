<main class="main_secciones">
    <form class="formulario" action='/' method="post">
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

    if (count($data)) {
        foreach ($data as $key => $error) {
            echo $error;
        }
    }

    ?>
</main>