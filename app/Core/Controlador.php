<?php
declare(strict_types=1);

namespace App\Core;
use PDO;
class Controlador{

    public function __construct(protected PDO $pdo) {}
    
    public function renderizarVista(string $vista, array $datos=[]): void{
        $datos['alertasFlash'] = AlertaFlash::consumirTodas(); //para obtener las alertas
        extract($datos); //va a extraer las llaves del array para convertirlas en varriables, por ese debe de ser clave valor el array
        //generamos la ruta de la vista

        $rutaVista=__DIR__.'/../Views/'.$vista.'.php';
        //Verificamos que el archivo existe 
        if(!file_exists($rutaVista)){
            echo "Vista no encontrada".htmlspecialchars($rutaVista);
            return;
        }
        //si existe la importamos 
        require $rutaVista;
        require __DIR__ . '/../Views/components/alerta.php';


    }

    public function vistaNoEncontradad(){
        
    }
}
