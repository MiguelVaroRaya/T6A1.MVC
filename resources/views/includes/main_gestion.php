<main class="main_secciones">

    <form class="formulario_busqueda" action='gestion' method="post">
        <label for="id">ID:</label>
        <input type="text" name="id">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre">
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellidos">
        <label for="user">User:</label>
        <input type="text" name="user">
        <label for="email">Email:</label>
        <input type="text" name="email">
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha">
        <label for="saldo_min">Saldo mínimo:</label>
        <input type="number" name="saldo_min">
        <label for="saldo_max">Saldo máximo:</label>
        <input type="number" name="saldo_max">
        <input type="submit" name="filtrar" value="Aplicar Filtro">
    </form>


    <table class=tabla_precios>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>User</th>
            <th>Email</th>
            <th>Fecha</th>
            <th>Saldo</th>
            <th>Editar</th>
            <th>Borrar</th>
        </tr>
        <?php

        foreach ($data["busqueda"] as $usuario) {
            echo ("<tr>");
            echo ("<td>" . $usuario["id"] . "</td>");
            echo ("<td>" . $usuario["nombre"] . "</td>");
            echo ("<td>" . $usuario["apellidos"] . "</td>");
            echo ("<td>" . $usuario["nombre_usuario"] . "</td>");
            echo ("<td>" . $usuario["email"] . "</td>");
            echo ("<td>" . $usuario["fecha_nacimiento"] . "</td>");
            echo ("<td>" . $usuario["saldo"] . "</td>");
            echo ("<td><a href='/usuario/editar/" . $usuario["id"] . "' class=tabla-links>Editar</a></td>");
            echo ("<td><a href='/usuario/borrar/" . $usuario["id"] . "' class=tabla-links>Borrar</a></td>");
            echo ("</tr>");
        }
        ?>
    </table>

    <div class="paginador">
        <ul>
            <?php

            if ($_REQUEST["p"] != 1) {
                echo ("<li><a href='/gestion?p=1'>|<</a></li>");
                echo ("<li><a href='/gestion?p=" . ($_REQUEST["p"] - 1) . "'><<</a></li>");
            }

            for ($i = 1; $i <= $data["paginas"]; $i++) {
                if ($i == $_REQUEST["p"]) {
                    echo ("<li class=pageSelected>" . $i . "</li>");
                } else {
                    echo ("<li><a href='/gestion?p=" . $i . "'>" . $i . "</a></li>");
                }
            }

            if ($_REQUEST["p"] != $data["paginas"] && $data["paginas"] != 0) {
                echo ("<li><a href='/gestion?p=" . ($_REQUEST["p"] + 1) . "'>>></a></li>");
                echo ("<li><a href='/gestion?p=" . $data["paginas"] . "'>>|</a></li>");
            }
            ?>
        </ul>
    </div>
</main>