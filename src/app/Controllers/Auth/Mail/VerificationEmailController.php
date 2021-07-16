<?php
namespace App\Controllers\Auth\Mail;
// TODO: Archivo controlador de la password ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use Slim\Routing\RouteContext;
class VerificationEmailController extends Controller
{
    public function index(Request $request, Response $response)
    {
       return $this->view->render($response, 'Auth/Secure/change.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
    public function VerificationEmail(Request $request, Response $response)
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $params = (array)$request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
    }
}
