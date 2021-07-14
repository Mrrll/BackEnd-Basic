<?php
namespace App\Controllers\Auth\Secure;
// TODO: Archivo controlador de la password ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use Slim\Routing\RouteContext;
class PasswordController extends Controller
{
    public function index(Request $request, Response $response)
    {
       return $this->view->render($response, 'Auth/Secure/change.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
    public function ChangePassword(Request $request, Response $response)
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $params = (array)$request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
        $validation = $this->validator->validate($request, [
            'password_old' => v::noWhitespace()
                ->notEmpty()
                ->matchesPassword($this->auth->user()->getPassword()), // ?: Regla personalizada ...
            'password' => v::noWhitespace()->notEmpty(),
        ]);
        if ($validation->failed()) {
            return $response->withHeader('Location',  $routes->urlFor('auth.password.change'));// ?: Redireccionamos a la plantilla ...
        } //*: Comprobamos si los datos estan validados ...
    }
}
