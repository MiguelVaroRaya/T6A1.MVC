<main class="main_secciones">
    <form class="formulario" action='/usuario/<?php echo $data[0] ?>' method="post">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $data[1]["nombre"]; ?>">
        <br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" value="<?php echo $data[1]["apellidos"]; ?>">
        <br><br>

        <label for="user">Nombre de usuario:</label>
        <input type="text" name="user" value="<?php echo $data[1]["nombre_usuario"]; ?>">
        <br><br>

        <label for="email">Correo electrónico:</label>
        <input type="text" name="email" value="<?php echo $data[1]["email"]; ?>">
        <br><br>

        <label for="fecha">Fecha de nacimiento:</label>
        <input type="date" name="fecha" value="<?php echo $data[1]["fecha_nacimiento"]; ?>">
        <br><br>

        <label for="saldo">Saldo:</label>
        <input type="number" name="saldo" value="<?php echo $data[1]["saldo"]; ?>">
        <br><br>

        <input type="submit" name="enviar" value="Modificar">
    </form>

    <form class="formulario" action='/usuario/<?php echo $data[0] ?>' method="post">

        <label for="nombre_user">Nombre de usuario:</label>
        <input type="text" name="nombre_user">
        <br><br>

        <label for="cantidad">Cantidad:</label>
        <input type="text" name="cantidad">
        <br><br>

        <input type="submit" name="transaccion" value="Realizar transaccion">
    </form>

    <?php

    if (count($data[2])) {
        foreach ($data as $key => $error) {
            echo ("<p class=error><br>$error</p>");
        }
    }

    ?>
</main>