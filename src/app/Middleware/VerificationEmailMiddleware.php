<?php
namespace App\Middleware;
// TODO: Archivo que gestiona el permisos hacia las rutas si hay sesion abierta ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
class VerificationEmailMiddleware extends Controller
{
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
         $response = $handler->handle($request);

        return $response;
    }
}
