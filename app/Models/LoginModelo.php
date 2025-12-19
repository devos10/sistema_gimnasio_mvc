<?php 

namespace App\Models;
use App\Core\MainModel;
use PDO;
class LoginModelo extends MainModel{

    public function validarUsuario(string $usuario, string $password){
        $sql=$this->ejecutarConsulta(
            "SELECT * FROM usuario WHERE nombre= :usuario AND contraseña= :pass",
            ['usuario'=>$usuario,'pass'=>$password]

        );
        if($sql->rowCount()===1){
            $fila = $sql->fetch(PDO::FETCH_ASSOC);
            return $fila; // login válido
        }
        return false; // credenciales inválidas
        }



    }


