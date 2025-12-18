<?php
declare(strict_types=1);

namespace App\Core;

use PDO;


final class Database
{
    public static function conexion(): PDO
    {
        $dsn = DB_GESTOR . ':host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8mb4';

        return new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }
}
