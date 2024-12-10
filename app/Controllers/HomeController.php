<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use PDOException;

class HomeController extends Controller
{
    // La página principal mostrará un listado de usuarios
    public function index()
    {

        $errores = [];
        $cambio = false;

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

            if ($errorNum == 0) {
                try {
                    $usuarioModel = new UsuarioModel();
                    $usuariosTotal = $usuarioModel->select("id", "nombre_usuario", "password")->get();
                } catch (PDOException $e) {
                }

                foreach ($usuariosTotal as $usuario) {
                    if ($usuario["nombre_usuario"] == $user) {
                        if (password_verify($password, $usuario["password"])) {
                            $_SESSION["id"] = $usuario["id"];
                            $_SESSION["columnas"] = [];
                            $_SESSION["valores"] = [];
                            $_SESSION["valoresSaldo"] = [];
                            $cambio = true;
                            header("location: /");
                        }
                    }
                }

                if (!$cambio) {
                    $errores[] = "<p class=error>Datos incorrectos</p>";
                }
            }
        }
        return $this->view('principal', $errores); // Seleccionamos una vista (método padre)
    }
}
