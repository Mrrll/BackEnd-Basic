<?php
namespace App\Controllers;
// TODO: Archivo de Controlador de la vista Welcom ...
class HomeController extends Controller
{
    // *: Muestra la peticion get del controlador ...
    public function index($request, $response)
    {
        return $this->view->render($response, 'home.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
}
