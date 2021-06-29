<?php
namespace App\Controllers\Auth;
// TODO: Archivo controlador base de controladores de authentication ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
class RegisterController extends Controller
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'Auth/register.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
}
