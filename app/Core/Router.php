<?php
declare(strict_types=1);

namespace App\Core;
use PDO;
class Router
{
    public function __construct(private PDO $pdo) {}
    public function obtener(){
        //vamos a obtener tanto el controlador como el metodo requerido 
        $controlador=$_GET['controlador']??'home';
        $accion=$_GET['accion']??'index';
        //en caso de que este vacio el controlador y la accion le ponemos por defecto Home e index

        //pasamos a contruir el nombre del controlador
        $nombreControlador="\\App\Controllers\\".ucfirst($controlador).'Controlador';
        //vamos a usar al inicio como le pondremos el namespace, despues con ucfisrts convertira la primera letra de la cadena en mayuscula y le concatenamos el nombre Controlador
       
        //creamos una variable que contendra la accion o en este caso el metodo
        $metodo = $accion;

        //verificamos que exista el controlador

        if(!class_exists($nombreControlador)){
            $this->renderizarVista404("Controlador no encontrado");
            return;
        }

        //creamos una instancia en caso de que si  exista el controlador

        $objetoControlador=new $nombreControlador($this->pdo);
        
        //ya hecha la instancia verificamos que exista el metodo que queremos usar
        if(!method_exists($objetoControlador,$metodo)){
            echo "Metodo no existente";
            return;
        }
        //si existe entonces lo llamamos
        $objetoControlador->$metodo();
        
        $controlador='';
        $metodo='';

    }

        private function renderizarVista404(string $mensaje): void
    {
        $appName = APP_NAME;
        require __DIR__ . '/../Views/errors/404.php';
    }
}