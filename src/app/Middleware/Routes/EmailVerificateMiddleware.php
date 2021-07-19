<?php
namespace App\Middleware\Routes;
// TODO: Archivo que gestiona el permisos hacia las rutas si el email esta verificado ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
class EmailVerificateMiddleware extends Controller
{
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
        $response = $handler->handle($request);
        if ($this->auth->verification()) {
            // *: Mensaje alert desde flash slim ...
            $this->flash->addMessage('info', 'Your account verification is already validated.');
            return $response->withHeader('Location',  $routes->urlFor('home'));// ?: Redireccionamos a la plantilla ...
        } // ?: Si la verificacion no es valida ...
        return $response;
    }
}
