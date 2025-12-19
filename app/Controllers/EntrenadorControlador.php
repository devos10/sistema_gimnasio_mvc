<?php
namespace App\Controllers;
use App\Core\Controlador;
    class EntrenadorControlador extends Controlador{

        public function index(){

            $this->renderizarVista('entrenador/dashboard',
                [
                    'titulo'=>'Dashboard',
                    'mensaje'=>'Bienvenido Entrenador',
                ]
                );
        }

    }



?>