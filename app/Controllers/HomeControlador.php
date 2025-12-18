<?php 

namespace App\Controllers;

use App\Core\Controlador;

class HomeControlador extends Controlador{

    //este sera el metodo que se usara para el inicio
    public function index():void{

        $this->renderizarVista('home/inicio',[
            'titulo'=>'Inicio',
            'mensaje'=>'Bienvenido a mi mvc'
        ]);

    }

}