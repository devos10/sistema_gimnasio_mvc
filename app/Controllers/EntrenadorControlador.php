<?php

namespace App\Controllers;

use App\Core\AlertaFlash;
use App\Core\Controlador;
use App\Core\Validador;
use App\Models\EntrenadorModelo;
use App\Models\CategoriaModelo;
use PDOException;

class EntrenadorControlador extends Controlador
{

    public function index()
    {

        $this->renderizarVista(
            'entrenador/dashboard',
            [
                'titulo' => 'Dashboard',
                'mensaje' => 'Bienvenido Entrenador',
            ]
        );
    }

 
}
