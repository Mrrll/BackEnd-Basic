<?php
namespace App\Controllers\Auth;
// TODO: Archivo controlador base de controladores de authentication ...
// *: Importamos las classes necesarias ...
require_once __DIR__ . '/../../../../vendor/autoload.php';
use Slim\App;
use App\Controllers\Controller;
use App\Models\Usuarios;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use Slim\Routing\RouteContext;
class LoginController extends Controller
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'Auth/login.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
    public function login(Request $request, Response $response)
    {

    }
}
