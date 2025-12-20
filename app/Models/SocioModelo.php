<?php
namespace App\Models;
use App\Core\MainModel;
use PDO;
class SocioModelo extends MainModel{
    
     public function crearSocio(array $datosSocio): int
    {
        $this->ejecutarConsulta("
            INSERT INTO CLIENTE (
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

    public function listarSocios(array $limite){
        $sql=$this->ejecutarConsulta(
        "SELECT 
            c.id_cliente,
            c.nombre,
            c.apellido1,
            c.apellido2,
            c.edad,
            c.numero_telefono,
            c.contacto_familiar,
            c.descripcion_medica,
            c.foto,
            c.qr,
            c.id_categoria,
            cat.nombre AS nombre_categoria
        FROM CLIENTE c
		LEFT JOIN 
            CATEGORIA cat ON c.id_categoria= cat.id_categoria
        ORDER BY c.id_cliente ASC LIMIT :inicio,:hasta;
        ",
        $limite);
        $clientes = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $clientes; // lista de todos los clientes con informacion
    }

    public function contarSociosTotales(){
        $sql=$this->ejecutarConsulta("SELECT COUNT(*) FROM cliente;");
        return $sociosTotales=$sql->fetchColumn();
    }
}