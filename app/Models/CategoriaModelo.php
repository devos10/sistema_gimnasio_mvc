<?php 

namespace App\Models;

use App\Core\MainModel;
use PDO;
class CategoriaModelo extends MainModel{
        public function obtenerCategorias(): array{
        $categorias=$this->ejecutarConsulta(
            'SELECT * FROM categoria'
        );

        return  $categorias->fetchAll(PDO::FETCH_ASSOC);
    }
}