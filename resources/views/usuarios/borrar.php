<?php

use App\Models\UsuarioModel;

$usuarioModel = new UsuarioModel();

$usuarioModel->delete($data);

header("location: /gestion");