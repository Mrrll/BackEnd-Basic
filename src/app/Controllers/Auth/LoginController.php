<?php
namespace App\Controllers\Auth;
// TODO: Archivo controlador base de controladores de authentication ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
class LoginController extends Controller
{
    public function index(Request $request, Response $response)
    {
        return $this->view->render($response, 'Auth/login.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
    public function login(Request $request, Response $response)
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $params = (array)$request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
        // *: Logeamos al usuario ...
        $auth = $this->auth->attempt(
            $params['email'],
            $params['password'],
            (isset($params['remember_me'])) ? $params['remember_me'] : null
        ); // ?: Llamamos al metodo del clase auth y le pasamos el email y password ...
        if(!$auth){
            $this->flash->addMessage('error', 'Could no sign you in with those details.');
             return $response->withHeader('Location',  $routes->urlFor('auth.login'));// ?: Redireccionamos a la plantilla ...
        }
        // *: Redireccionamiento ...
        return $response->withHeader('Location',  $routes->urlFor('home'));// ?: Redireccionamos a la plantilla ...
    }
    public function logout(Request $request, Response $response)
    {
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        $this->auth->logout();
        return $response->withHeader('Location',  $routes->urlFor('auth.login'));// ?: Redireccionamos a la plantilla ...
    }
}
