<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOStatement;

abstract class MainModel
{
    public function __construct(protected PDO $pdo) {}

    public function ejecutarConsulta(string $consulta,array $parametros=[]): PDOStatement{
        $sql=$this->pdo->prepare($consulta);
        $sql->execute($parametros);
        return $sql;


    }


}

