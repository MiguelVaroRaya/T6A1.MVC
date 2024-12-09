<?php

use App\Models\UsuarioModel;

if (empty($_REQUEST["p"])) {
    $_REQUEST["p"] = 1;
}

if ($_REQUEST["p"] == "") {
    $_REQUEST["p"] = 1;
}

$usuarioModel = new UsuarioModel();
$usuariosTotal = $usuarioModel->select("id", "nombre", "apellidos", "nombre_usuario", "email", "fecha_nacimiento", "saldo")->get();
$cantidad = count($usuariosTotal);
$registros = 5;
$pagina = $_REQUEST["p"];
if (is_numeric($pagina)) {
    $inicio = ($pagina - 1) * $registros;
} else {
    $inicio = 0;
}
$busqueda = $usuarioModel->select("id", "nombre", "apellidos", "nombre_usuario", "email", "fecha_nacimiento", "saldo")->limit($inicio, $registros)->get();
$paginas = ceil($cantidad / $registros);
?>

<main class="main_secciones">
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

        foreach ($busqueda as $usuario) {
            echo ("<tr>");
            echo ("<td>" . $usuario["id"] . "</td>");
            echo ("<td>" . $usuario["nombre"] . "</td>");
            echo ("<td>" . $usuario["apellidos"] . "</td>");
            echo ("<td>" . $usuario["nombre_usuario"] . "</td>");
            echo ("<td>" . $usuario["email"] . "</td>");
            echo ("<td>" . $usuario["fecha_nacimiento"] . "</td>");
            echo ("<td>" . $usuario["saldo"] . "</td>");
            echo ("<td><a href='/usuario/" . $usuario["id"] . "' class=tabla-links>Editar</a></td>");
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

            for ($i = 1; $i <= $paginas; $i++) {
                if ($i == $_REQUEST["p"]) {
                    echo ("<li class=pageSelected>" . $i . "</li>");
                } else {
                    echo ("<li><a href='/gestion?p=" . $i . "'>" . $i . "</a></li>");
                }
            }

            if ($_REQUEST["p"] != $paginas) {
                echo ("<li><a href='/gestion?p=" . ($_REQUEST["p"] + 1) . "'>>></a></li>");
                echo ("<li><a href='/gestion?p=" . $paginas . "'>>|</a></li>");
            }
            ?>
        </ul>
    </div>
</main>