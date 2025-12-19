<?php

namespace App\Controllers;

use App\Core\Controlador;
use App\Core\Validador;
use App\Core\AlertaFlash;
use App\Core\Autenticacion;
use App\Models\LoginModelo;

class LoginControlador extends Controlador
{
    public function index(): void
    {
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);

        $this->renderizarVista('home/login', [
            'titulo' => 'Login',
            'old' => $old,
            'css' => 'login.css'
        ]);
    }

    public function verificar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controlador=login&accion=index');
            exit;
        }

        $usuario   = $_POST['usuario'] ?? '';
        $password  = $_POST['password'] ?? '';

        $validador = new Validador();
        $validador->validarNoVacio('usuario', $usuario);
        $validador->validarNoVacio('password', $password);
        $usuario = $validador->limpiarCadena($usuario);
        $password = $validador->limpiarCadena($password);

        if ($validador->tieneErrores()) {
            $_SESSION['old'] = ['usuario' => $usuario];

            $items = '';
            foreach ($validador->obtenerErrores() as $campo => $mensajes) {
                foreach ($mensajes as $msg) {
                    $items .= '<li>' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</li>';
                }
            }

            AlertaFlash::error('Corrige el formulario', '', [
                'html' => '<ul style="text-align:left; margin:0; padding-left:18px;">' . $items . '</ul>',
                'icon' => 'error',
            ]);

            header('Location: ?controlador=login&accion=index');
            exit;
        }

        $modelo = new LoginModelo($this->pdo);
        $datosLogin = $modelo->validarUsuario($usuario, $password);

        if ($datosLogin) {
            Autenticacion::login($datosLogin);
            AlertaFlash::exito(
                "Inicio correcto",
                "Inicio de sesión exitoso",
                [
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 3000,
                    'showConfirmButton' => false,
                    'timerProgressBar' => true
                ]
            );
            header('Location: ?controlador=entrenador&accion=index');
            exit;
        } else {
            AlertaFlash::error(
                "Usuario Inválido",
                "Usuario o Contraseña incorrectos!!!",
                [
                    //'toast' => true,
                    'position' => 'center',
                    //'timer' => 2000,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Entendido',
                    //'timerProgressBar'=> true,
                    'icon' => 'error',
                ]
            );
            header('Location: ?controlador=login&accion=index');
            exit;
        }
    }
}
