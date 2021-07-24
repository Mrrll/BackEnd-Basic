<?php
namespace App\Middleware;
// TODO: Archivo que gestiona el Nombre de las rutas ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
class RoutesNameMiddleware extends Controller
{
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        $RouteName = RouteContext::fromRequest($request)->getRoute()->getName();// ?: Obtiene el nombre de la ruta ...
        $this->view->getEnvironment()->addGlobal('routeCurrent', $RouteName); // ?: Enviamos a la vista el nombre de la ruta ...
        $response = $handler->handle($request);
        return $response;
    }
}
