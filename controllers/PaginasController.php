<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {
        $propiedades = Propiedad::get(3);
        $inicio = true;
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router) {
        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router) {
        $id = validarORedireccionar('propiedades');

        if($id) {
            $propiedad = Propiedad::find($id);
        }

        $router -> render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function blog(Router $router) {
        $router -> render('paginas/blog');
    }

    public static function entrada(Router $router) {
        
        $router -> render('paginas/entrada', [

        ]);
    }

    public static function contacto(Router $router) {
        $mensaje = null;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = $_POST['contacto'];

            
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = 'cfc1e6f9ec89c3';
            $phpmailer->Password = '2f915213d33b99';
            $phpmailer->SMTPSecure = 'tls';

            // Configurar el contenido del mail
            $phpmailer->setFrom('admin@bienesraices.com', 'BienesRaices');
            $phpmailer->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $phpmailer->Subject = 'Tienes un nuevo mensaje';

            // Habilitar HTML
            $phpmailer->isHTML(true);
            $phpmailer->CharSet = 'UTF-8';

            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p> Tienes un nuevo mensaje </p>';
            $contenido .= '<p> Nombre: ' . $respuestas['nombre'] .  '</p>';
            
            // Enviar condicionalmente campos de telefono o emial
            if($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligió ser contactado por teléfono</p>';
                $contenido .= '<p> Teléfono: ' . $respuestas['telefono'] .  '</p>';
                $contenido .= '<p> Fecha para contactar: ' . $respuestas['fecha'] .  '</p>';
                $contenido .= '<p> Hora para contactar: ' . $respuestas['hora'] .  '</p>';
            } else {
                // Es email, agregamos el campo email
                $contenido .= '<p>Eligió ser contactado por email</p>';
                $contenido .= '<p> Email: ' . $respuestas['email'] .  '</p>';
            }
            
            $contenido .= '<p> Mensaje: ' . $respuestas['mensaje'] .  '</p>';
            $contenido .= '<p> Tipo de transacción: ' . $respuestas['tipo'] .  '</p>';
            $contenido .= '<p> Presupuesto: $' . $respuestas['presupuesto'] .  '</p>';
            $contenido .= '<p> Método de contacto preferido: ' . $respuestas['contacto'] .  '</p>';
            $contenido .= '</html>';

            $phpmailer->Body = $contenido;
            $phpmailer->AltBody = 'Esto es un texto alternativo sin HTML';

            // Enviar el mail
            if($phpmailer->send()) {
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar";
            }
        }
        
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}