<?php
namespace App\Middleware\Routes;
// TODO: Archivo que gestiona el permisos hacia las rutas si hay sesion abierta ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
class GuestMiddleware extends Controller
{
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
         // *: Compruebe si el usuario no ha iniciado sesión ...
         $response = $handler->handle($request);
        if ($this->auth->check()) {
            // *: Mensaje alert desde flash slim ...
            $this->flash->addMessage('info', 'There is already a login open.');
            if (!$this->auth->verification() && !isset($_SESSION['verification'])) {
                return $response->withHeader('Location',  $routes->urlFor('auth.verification.send'));// ?: Redireccionamos a la plantilla ...
            } else {
                return $response->withHeader('Location',  $routes->urlFor('home'));// ?: Redireccionamos a la plantilla ...
            }
        }
        return $response;
    }
}
