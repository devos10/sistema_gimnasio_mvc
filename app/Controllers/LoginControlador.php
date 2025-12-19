<?php

namespace App\Controllers;
//clases usadas
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
        //verificamos que se envie por POST si no redigire al login
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controlador=login&accion=index');
            exit;
        }
        //recibimos las variables post 
        $usuario   = $_POST['usuario'] ?? '';
        $password  = $_POST['password'] ?? '';
        //hacemos uso del validador para veirificar que las variables no esten vacias y limpiarlas
        $validador = new Validador();
        $validador->validarNoVacio('usuario', $usuario);
        $validador->validarNoVacio('password', $password);
        $usuario = $validador->limpiarCadena($usuario);
        $password = $validador->limpiarCadena($password);
        //si el validador nos devuelve errores 
        if ($validador->tieneErrores()) {
            //generamos variable de sesion con los datos de los camps que se enviaron y recibieron
            $_SESSION['old'] = ['usuario' => $usuario];

            $items = '';
            //recorremos los errores
            foreach ($validador->obtenerErrores() as $campo => $mensajes) {
                foreach ($mensajes as $msg) {
                    //guardamos en items cada error 
                    $items .= '<li>' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</li>';
                }
            }
            //hacemos uso de la clase alerta para generar una alerta con los multiples errores
            AlertaFlash::error('Corrige el formulario', '', [
                'html' => '<ul style="text-align:left; margin:0; padding-left:18px;">' . $items . '</ul>',
                'icon' => 'error',
            ]);
            //la redireccion es al mismo login
            header('Location: ?controlador=login&accion=index');
            exit;
        }
        //creamos una variable del modelo
        $modelo = new LoginModelo($this->pdo);
        //creamos una variable que guardara los datos retornados por el metodo del modelo
        $datosLogin = $modelo->validarUsuario($usuario, $password);
        //verificamos si datos contiene informacion 
        if ($datosLogin) {
            //si tenemos datos hacemos uso de la clase autenticacion, usando el metodo login y enviendole los datos
            Autenticacion::login($datosLogin); //crea un array de sesion con los datos del usuario legueado
            //se muestra alerta exitosa
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
            //redireccionamos al dashboard del entrenador
            header('Location: ?controlador=entrenador&accion=index');
            exit;
            //si no se recibieron datos
        } else {
            //se envia una alerta tipo modal indicando que las credenciales no son validas

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
            //redireccionamos de nuevo al login 
            header('Location: ?controlador=login&accion=index');
            exit;
        }
    }
}
