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
    public function index(Request $request, Response $response)
    {
        return $this->view->render($response, 'Auth/login.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
    public function login(Request $request, Response $response)
    {
        $params = (array)$request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        $auth = $this->auth->attempt(
            $params['email'],
            $params['password']
        ); // ?: Llamamos al metodo del clase auth y le pasamos el email y password ...
        if(!$auth){
             return $response->withHeader('Location',  $routes->urlFor('auth.login'));// ?: Redireccionamos a la plantilla ...
        }
        // *: Redireccionamiento ...
        return $response->withHeader('Location',  $routes->urlFor('home'));// ?: Redireccionamos a la plantilla ...
    }
    public function logout(Request $request, Response $response)
    {
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        $this->auth->logout();
        return $response->withHeader('Location',  $routes->urlFor('welcom'));// ?: Redireccionamos a la plantilla ...
    }
}
