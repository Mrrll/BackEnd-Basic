<?php
namespace App\Middleware;
// TODO: Archivo que gestiona el Token Csrf ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
class CookieMiddleware extends Controller
{
    public function __invoke(
        Request $request,
        RequestHandler $handler
    ): Response {
        $response = $handler->handle($request);
        if (isset($_COOKIE['remember_user_session']) && !$this->auth->check()) {
            $this->auth->attemptRemember();
            $routes = RouteContext::fromRequest($request)->getRouteParser(); // ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
            // *: Redireccionamiento ...
            return $response->withHeader('Location', $routes->urlFor('welcom')); // ?: Redireccionamos a la plantilla ...
        }
        return $response;
    }
}
