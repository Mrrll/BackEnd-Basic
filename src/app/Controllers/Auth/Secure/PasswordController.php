<?php
namespace App\Controllers\Auth\Secure;
// TODO: Archivo controlador de la password ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
class PasswordController extends Controller
{
    public function index(Request $request, Response $response)
    {
       return $this->view->render($response, 'Auth/Secure/change.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
    public function ChangePassword(Request $request, Response $response)
    {

    }
}
