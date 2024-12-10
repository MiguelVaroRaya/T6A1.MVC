<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class UsuarioController extends Controller
{
    public function index()
    {
        // Creamos la conexión y tenemos acceso a todas las consultas sql del modelo
        $usuarioModel = new UsuarioModel();

        // Se recogen los valores del modelo, ya se pueden usar en la vista
        $usuarios = $usuarioModel->consultaPrueba();

        return $this->view('usuarios.index', $usuarios); // compact crea un array de índice usuarios
    }

    public function create()
    {
        return $this->view('usuarios.create');
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

        for ($i = 0; $i < 25; $i++) {
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

    public function registro()
    {
        return $this->view('usuarios.registro');
    }

    public function gestionUser()
    {
        return $this->view('usuarios.gestionUsuarios');
    }

    public function store()
    {
        // Volvemos a tener acceso al modelo
        $usuarioModel = new UsuarioModel();

        // Se llama a la función correpondiente, pasando como parámetro
        // $_POST
        var_dump($_POST);
        echo "Se ha enviado desde POST";

        // Podríamos redirigir a donde se desee después de insertar
        //return $this->redirect('/contacts');
    }

    public function show($id)
    {
        $id = intval($id);
        return $this->view('usuarios.show', $id);
    }

    public function borrar($id)
    {
        return $this->view('usuarios.borrar', $id);
    }

    public function edit($id)
    {
        echo "Editar usuario";
    }

    public function update($id)
    {
        echo "Actualizar usuario";
    }

    public function destroy($id)
    {
        echo "Borrar usuario";
    }

    // Función para mostrar como fuciona con ejemplos
    public function pruebasSQLQueryBuilder()
    {
        // Se instancia el modelo
        $usuarioModel = new UsuarioModel();
        // Descomentar consultas para ver la creación
        //$usuarioModel->all();
        //$usuarioModel->select('columna1', 'columna2')->get();
        // $usuarioModel->select('columna1', 'columna2')
        //             ->where('columna1', '>', '3')
        //             ->orderBy('columna1', 'DESC')
        //             ->get();
        // $usuarioModel->select('columna1', 'columna2')
        //             ->where('columna1', '>', '3')
        //             ->where('columna2', 'columna3')
        //             ->where('columna2', 'columna3')
        //             ->where('columna3', '!=', 'columna4', 'OR')
        //             ->orderBy('columna1', 'DESC')
        //             ->get();
        //$usuarioModel->create(['id' => 1, 'nombre' => 'nombre1']);
        //$usuarioModel->delete(['id' => 1]);
        //$usuarioModel->update(['id' => 1], ['nombre' => 'NombreCambiado']);

        echo "Pruebas SQL Query Builder";
    }
}
