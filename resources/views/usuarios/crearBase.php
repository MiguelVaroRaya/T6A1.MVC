<?php

use App\Models\UsuarioModel;

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
$usuarioModel -> createTable($columnas);

$nombres = ["miguel", "david", "lucia", "laura", "antonio"];
$apellidos = ["garcia", "jimenez", "perez", "ruiz", "mora"];
$emails = ["emailprueba@gmail.com", "emailutil@gmail.com", "emailtrabajo@gmail.com", "emailcasa@gmail.com", "emailvacio@gmail.com"];
$fechasNac = ["2002-10-10", "1990-10-17", "1995-10-21", "2005-10-01", "2003-10-11"];
$password = "User123_";
$saldos = [785, 1900, 4130, 1050, 2420];

for ($i=0; $i < 25; $i++) { 
    $nombre = $nombres[array_rand($nombres)];
    $apellido = $apellidos[array_rand($apellidos)];
    $nombreUser = $nombre . $i;
    $email = $emails[array_rand($emails)];
    $fechaNac = $fechasNac[array_rand($fechasNac)];
    $saldo = $saldos[array_rand($saldos)];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $entrada = ["nombre" => $nombre, "apellidos" => $apellido, "nombre_usuario" => $nombreUser, "email" => $email, "fecha_nacimiento" => $fechaNac, "password" => $password_hash, "saldo" => $saldo];

    $usuarioModel -> create($entrada);
}

header("Location:/");