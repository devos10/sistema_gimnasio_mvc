<?php
require_once __DIR__."/../config/APP.php";
require_once __DIR__."/../config/DB.php";
require_once __DIR__."/../autoload.php";


/*creamos una instancia del router para que pueda hacer uso del metodo obtener
y asi determinar controladores y metodos a usar*/
use App\Core\Router;
use App\Core\Database;
if (session_status() !== PHP_SESSION_ACTIVE) session_start(); //creamos sesion si no existe

$pdo = Database::conexion(); //para que se cree una sola instancia de pdo o una sola conexion por request

$router = new Router($pdo); //se la pasamos al router

$router->obtener();


?>