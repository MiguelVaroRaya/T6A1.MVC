<?php

use App\Models\UsuarioModel;

if (!isset($_SESSION["id"])) {
    header("Location: /");
}

function filtrado(string $datos): string
{
    $datos = trim($datos); // Elimina espacios antes y después de los datos 
    $datos = stripslashes($datos); // Elimina backslashes \ 
    $datos = htmlspecialchars($datos);  // Traduce caracteres especiales en entidades HTML 
    return $datos;
}

if (isset($_POST["filtrar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $id = filtrado($_POST["id"]);
    $nombre = filtrado($_POST["nombre"]);
    $apellidos = filtrado($_POST["apellidos"]);
    $user = filtrado($_POST["user"]);
    $email = filtrado($_POST["email"]);
    $fecha = filtrado($_POST["fecha"]);
    $saldoMin = filtrado($_POST["saldo_min"]);
    $saldoMax = filtrado($_POST["saldo_max"]);
    $errorNum = 0;

    $_SESSION["columnas"] = [];
    $_SESSION["valores"] = [];

    if (!empty($id)) {
        $_SESSION["columnas"][] = "id";
        $_SESSION["valores"][] = $id;
    }

    if (!empty($nombre)) {
        $_SESSION["columnas"][] = "nombre";
        $_SESSION["valores"][] = $nombre;
    }

    if (!empty($apellidos)) {
        $_SESSION["columnas"][] = "apellidos";
        $_SESSION["valores"][] = $apellidos;
    }

    if (!empty($user)) {
        $_SESSION["columnas"][] = "nombre_usuario";
        $_SESSION["valores"][] = $user;
    }

    if (!empty($email)) {
        $_SESSION["columnas"][] = "email";
        $_SESSION["valores"][] = $email;
    }

    if (!empty($fecha)) {
        $_SESSION["columnas"][] = "fecha_nacimiento";
        $_SESSION["valores"][] = $fecha;
    }
}

if (empty($_REQUEST["p"])) {
    $_REQUEST["p"] = 1;
}

if ($_REQUEST["p"] == "") {
    $_REQUEST["p"] = 1;
}

$usuarioModel = new UsuarioModel();
$usuariosTotal = $usuarioModel->select("id", "nombre", "apellidos", "nombre_usuario", "email", "fecha_nacimiento", "saldo")->whereLike($_SESSION["columnas"], $_SESSION["valores"])->get();
$cantidad = count($usuariosTotal);
$registros = 5;
$pagina = $_REQUEST["p"];
if (is_numeric($pagina)) {
    $inicio = ($pagina - 1) * $registros;
} else {
    $inicio = 0;
}
$busqueda = $usuarioModel->select("id", "nombre", "apellidos", "nombre_usuario", "email", "fecha_nacimiento", "saldo")->whereLike($_SESSION["columnas"], $_SESSION["valores"])->limit($inicio, $registros)->get();
$paginas = ceil($cantidad / $registros);
?>

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

            if ($_REQUEST["p"] != $paginas && $paginas != 0) {
                echo ("<li><a href='/gestion?p=" . ($_REQUEST["p"] + 1) . "'>>></a></li>");
                echo ("<li><a href='/gestion?p=" . $paginas . "'>>|</a></li>");
            }
            ?>
        </ul>
    </div>
</main>