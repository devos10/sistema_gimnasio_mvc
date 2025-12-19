<?php 

namespace App\Controllers;

use App\Core\AlertaFlash;
use App\Core\Controlador;
use App\Core\Validador;
use App\Models\SocioModelo;
use App\Models\CategoriaModelo;
use PDOException;

class SocioControlador extends Controlador
{

    public function socio()
    {
        $modelo = new CategoriaModelo($this->pdo);
        $categorias=$modelo->obtenerCategorias();
        $this->renderizarVista(
            'socios/crear',
            ['titulo' => 'Nuevo Socio',
            'categorias'=> $categorias
            ]
        );
    }

    public function crearSocio()
    {
        //validamos que se envie por el metodo post
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controlador=socio&accion=socio');
            exit;
        }
        //recibimos variables
        $nombre = $_POST['nombre'] ?? '';
        $apellido1 = $_POST['apellido1'] ?? '';
        $apellido2 = $_POST['apellido2'] ?? '';
        $edad = $_POST['edad'] ?? 0;
        $numeroTelefono = $_POST['numero_telefono'] ?? '';
        $contactoFamiliar = $_POST['contacto_familiar'] ?? '';
        $descripcionMedica = $_POST['descripcion_medica'] ?? '';
        $idCategoria = $_POST['categoria'] ?? '';
        $foto = $_POST['foto'] ?? '';


        //validamos y limpiamos variables
        $validador = new Validador();
        $validador->validarNoVacio('nombre', $nombre);
        $validador->validarNoVacio('apellido1', $apellido1);
        $validador->validarNoVacio('edad', $edad);
        $validador->validarNoVacio('descripcion medica', $descripcionMedica);
        $validador->validarEntero('edad', $edad);
        $validador->validarTelefonoMx('Numero de telefono', $numeroTelefono);
        $validador->validarLongitudMaxima('Numero de telefono', $numeroTelefono, 10);
        $validador->validarLongitudMinima('Numero de telefono', $numeroTelefono, 10);
        $nombre = $validador->limpiarCadena($nombre);
        $apellido1 = $validador->limpiarCadena($apellido1);
        $apellido2 = $validador->limpiarCadena($apellido2);
        $numeroTelefono = $validador->limpiarTelefonoMx($numeroTelefono);

        //verificamos si existen errores 
        if ($validador->tieneErrores()) {
            //generamos variable de sesion con los datos de los campos que se volveran a mostrar en caso de error
            $_SESSION['old'] = [
                'nombre' => $nombre,
                'apellido1' => $apellido1,
                'edad' => $edad,
                'descripcion_medica' => $descripcionMedica
            ];

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

            //redireccionamos 
            header('Location: ?controlador=socio&accion=socio');
            exit;
        }

        //
        $qr = null;

        // 2) Arma UN SOLO ARRAY con keys que coincidan con tus placeholders
        $datosSocio = [
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'apellido2' => $apellido2,
            'edad' => (int) $edad,
            'numero_telefono' => $numeroTelefono,
            'contacto_familiar' => $contactoFamiliar,
            'descripcion_medica' => $descripcionMedica,
            'foto' => $foto,
            'id_categoria' => (int) $idCategoria,
            'qr' => $qr,
        ];

        //  Inserta con el modelo
        try {
            $modelo = new SocioModelo($this->pdo);
            $idNuevo = $modelo->crearSocio($datosSocio);

            AlertaFlash::exito('Cliente registrado', "ID #{$idNuevo}", [
                'toast' => true,
                'position' => 'top-end',
                'timer' => 2200,
                'showConfirmButton' => false
            ]);

            header('Location: ?controlador=socio&accion=socio');
            exit;
        } catch (PDOException $e) {
            AlertaFlash::error('No se pudo registrar el cliente', 'Intenta de nuevo.', [
                'toast' => true,
                'position' => 'top-end',
                'timer' => 2500,
                'showConfirmButton' => false
            ]);

            header('Location: ?controlador=socio&accion=socio');
            exit;
        }
    }
    
}
