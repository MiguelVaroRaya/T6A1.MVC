<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class UsuarioController extends Controller
{
    public function filtrado(string $datos): string
    {
        $datos = trim($datos); // Elimina espacios antes y después de los datos 
        $datos = stripslashes($datos); // Elimina backslashes \ 
        $datos = htmlspecialchars($datos);  // Traduce caracteres especiales en entidades HTML 
        return $datos;
    }
    public function crearBase()
    {
        $usuarioModel = new UsuarioModel();
        $columnas = [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'nombre' => 'TEXT NOT NULL',
            'apellidos' => 'TEXT NOT NULL',
            'nombre_usuario' => 'TEXT NOT NULL',
            'email' => 'TEXT NOT NULL',
            'fecha_nacimiento' => 'DATE NOT NULL',
            'password' => 'TEXT NOT NULL',
            'saldo' => 'INT NOT NULL'
        ];
        $usuarioModel->createTable($columnas);

        $nombres = ["miguel", "david", "lucia", "laura", "antonio"];
        $apellidos = ["garcia", "jimenez", "perez", "ruiz", "mora"];
        $emails = ["emailprueba@gmail.com", "emailutil@gmail.com", "emailtrabajo@gmail.com", "emailcasa@gmail.com", "emailvacio@gmail.com"];
        $fechasNac = ["2002-10-10", "1990-10-17", "1995-10-21", "2005-10-01", "2003-10-11"];
        $password = "User123_";
        $saldos = [785, 1900, 4130, 1050, 2420];

        for ($i = 0; $i < 100; $i++) {
            $nombre = $nombres[array_rand($nombres)];
            $apellido = $apellidos[array_rand($apellidos)];
            $nombreUser = $nombre . $i;
            $email = $emails[array_rand($emails)];
            $fechaNac = $fechasNac[array_rand($fechasNac)];
            $saldo = $saldos[array_rand($saldos)];
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $entrada = ["nombre" => $nombre, "apellidos" => $apellido, "nombre_usuario" => $nombreUser, "email" => $email, "fecha_nacimiento" => $fechaNac, "password" => $password_hash, "saldo" => $saldo];

            $usuarioModel->create($entrada);
        }

        header("Location:/");
    }

    public function cerrarSesion()
    {
        session_destroy();
        header("location: /");
    }

    public function gestionUser()
    {
        if (!isset($_SESSION["id"])) {
            header("Location: /");
        }

        if (isset($_POST["filtrar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $this->filtrado($_POST["id"]);
            $nombre = $this->filtrado($_POST["nombre"]);
            $apellidos = $this->filtrado($_POST["apellidos"]);
            $user = $this->filtrado($_POST["user"]);
            $email = $this->filtrado($_POST["email"]);
            $fecha = $this->filtrado($_POST["fecha"]);
            $saldoMin = $this->filtrado($_POST["saldo_min"]);
            $saldoMax = $this->filtrado($_POST["saldo_max"]);
            $errorNum = 0;

            $_SESSION["columnas"] = [];
            $_SESSION["valores"] = [];
            $_SESSION["valoresSaldo"] = [];

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

            if (!empty($saldoMin)) {
                $_SESSION["valoresSaldo"][] = $saldoMin;
            } else {
                $_SESSION["valoresSaldo"][] = 0;
            }

            if (!empty($saldoMax)) {
                $_SESSION["valoresSaldo"][] = $saldoMax;
            } else {
                $_SESSION["valoresSaldo"][] = 999999999;
            }
        }

        if (empty($_REQUEST["p"])) {
            $_REQUEST["p"] = 1;
        }

        if ($_REQUEST["p"] == "") {
            $_REQUEST["p"] = 1;
        }

        $usuarioModel = new UsuarioModel();
        $usuariosTotal = $usuarioModel->select("id", "nombre", "apellidos", "nombre_usuario", "email", "fecha_nacimiento", "saldo")->whereLike($_SESSION["columnas"], $_SESSION["valores"])->whereBetween("saldo", $_SESSION["valoresSaldo"])->get();
        $cantidad = count($usuariosTotal);
        $registros = 5;
        $pagina = $_REQUEST["p"];
        if (is_numeric($pagina)) {
            $inicio = ($pagina - 1) * $registros;
        } else {
            $inicio = 0;
        }
        $busqueda = $usuarioModel->select("id", "nombre", "apellidos", "nombre_usuario", "email", "fecha_nacimiento", "saldo")->whereLike($_SESSION["columnas"], $_SESSION["valores"])->whereBetween("saldo", $_SESSION["valoresSaldo"])->limit($inicio, $registros)->get();
        $paginas = ceil($cantidad / $registros);

        $data["busqueda"] = $busqueda;
        $data["paginas"] = $paginas;

        return $this->view('usuarios.gestionUsuarios', $data);
    }

    public function show($id)
    {
        $errores = [];
        $data[] = $id;

        if (!isset($_SESSION["id"]) || $_SESSION["id"] != $id) {
            header("Location: /");
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($id);
        $data[] = $usuario;

        if (isset($_POST["enviar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $this->filtrado($_POST["nombre"]);
            $apellido = $this->filtrado($_POST["apellido"]);
            $user = $this->filtrado($_POST["user"]);
            $email = $this->filtrado($_POST["email"]);
            $fecha = $this->filtrado($_POST["fecha"]);
            $saldo = $this->filtrado($_POST["saldo"]);
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

            if ($errorNum == 0) {
                $usuarioModel->update($id, ["nombre" => $nombre, "apellidos" => $apellido, "nombre_usuario" => $user, "email" => $email, "fecha_nacimiento" => $fecha, "saldo" => $saldo]);
                header("location: /usuario/" . $id);
            }
        }

        if (isset($_POST["transaccion"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $nombreUsuario = $this->filtrado($_POST["nombre_user"]);
            $cantidad = $this->filtrado($_POST["cantidad"]);
            $errorNum = 0;

            if (empty($nombreUsuario) || !preg_match('/^[a-zA-Z0-9]{1,20}$/', $nombreUsuario)) {
                $errorNum++;
                $errores[] = "El nombre de usuario no cumple el formato correcto.";
            }

            if (empty($cantidad) || !preg_match('/^[0-9]+$/', $cantidad)) {
                $errorNum++;
                $errores[] = "La cantidad no cumple el formato correcto";
            }

            if ($errorNum == 0) {
                $usuarioModel->enviarDinero($usuario, $nombreUsuario, $cantidad);
                header("location: /usuario/" . $id);
            }
        }

        $data[] = $errores;

        return $this->view('usuarios.show', $data);
    }

    public function borrar($id)
    {
        $usuarioModel = new UsuarioModel();

        $usuarioModel->delete($id);

        header("location: /gestion");
    }

    public function editar($id)
    {
        $errores = [];
        $data[] = $id;

        if (!isset($_SESSION["id"])) {
            header("Location: /");
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($id);
        $data[] = $usuario;

        if (isset($_POST["enviar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $this->filtrado($_POST["nombre"]);
            $apellido = $this->filtrado($_POST["apellido"]);
            $user = $this->filtrado($_POST["user"]);
            $email = $this->filtrado($_POST["email"]);
            $fecha = $this->filtrado($_POST["fecha"]);
            $saldo = $this->filtrado($_POST["saldo"]);
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

            if ($errorNum == 0) {
                $usuarioModel->update($id, ["nombre" => $nombre, "apellidos" => $apellido, "nombre_usuario" => $user, "email" => $email, "fecha_nacimiento" => $fecha, "saldo" => $saldo]);
                header("location: /gestion");
            }
        }
        $data[] = $errores;

        return $this->view('usuarios.editar', $data);
    }
}
