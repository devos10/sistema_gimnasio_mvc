<?php

namespace App\Core;

class Autenticacion{
    
    public static function login(array $usuario):void{
        session_regenerate_id(true);
        $_SESSION['login'] = [
                'id' => $usuario['id_usuario']?? 0,
                'nombre' => $usuario['nombre']?? '',
                'rol' => $usuario['id_rol']?? 0
        ];
    }
//verifica que existe una session creada y que la sesion sea un arreglo
     public static function verificar(): bool
    {
        return isset($_SESSION['login']) && is_array($_SESSION['login']);
    }

    //nos retorna el array del  usuario si no deja a la variable de sesion como nulo
    public static function usuario(): ?array
    {
        return self::verificar() ? $_SESSION['login'] : null;
    }
    //verifica que exista el arreglo de sesion del usuario, si es que existe entonces retornara el rol de usuario si no lo pondra en nulo
    public static function rol(): ?string
    {
        return self::verificar() ? (string)($_SESSION['login']['rol'] ?? null) : null;
    }

    //verifica que exista el arreglo de sesion si no existe nos redirige a donde le indiquemos por medio del parametro
    public static function requireLogin(string $redireccion='?controlador=login&accion=index'): void
    {
        if (!self::verificar()) {
            header("Location: $redireccion");
            exit;
        }
    }

}