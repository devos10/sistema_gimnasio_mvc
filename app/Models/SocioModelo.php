<?php
namespace App\Models;
use App\Core\MainModel;

class SocioModelo extends MainModel{
    
     public function crearSocio(array $datosSocio): int
    {
        $this->ejecutarConsulta("
            INSERT INTO cliente (
                nombre, apellido1, apellido2, edad,
                numero_telefono, contacto_familiar,
                descripcion_medica, foto, id_categoria, qr
            ) VALUES (
                :nombre, :apellido1, :apellido2, :edad,
                :numero_telefono, :contacto_familiar,
                :descripcion_medica, :foto, :id_categoria, :qr
            )
        ", $datosSocio);

        return (int) $this->pdo->lastInsertId();
    }
}