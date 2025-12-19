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

        public function socio(){
            $this->renderizarVista('clientes/crear',
            ['titulo'=>'Nuevo Socio']
        );
        }

        public function crearSocio(){
            //validamos que se envie por el metodo post
            if($_SERVER['REQUEST_METHOD']!=='POST'){
                header('Location: ?controlador=entrenador&accion=socio');
                exit;
            }

        }
    }



?>