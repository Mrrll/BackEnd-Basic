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
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\DateTime;
use Respect\Validation\Validator as v;
use Slim\Routing\RouteContext;
class RegisterController extends Controller
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'Auth/register.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
    public function register(Request $request, Response $response)
    {
        $params = (array)$request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        $routes = RouteContext::fromRequest($request)->getRouteParser(); // ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // $usuarios = $this->db->getRepository(Usuarios::class)->findBy(array('name' => $params['name']));
        // foreach ($usuarios as $usuario) :
        //     // PHP_EOL fin de linea ...
        //     echo 'Nombre : ' . $usuario->getName(), PHP_EOL;
        //     $usuario->setName('Pablo');
        // endforeach;

        // die();
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()
                ->notEmpty()
                ->email(),
                // ->emailAvailable(), // ?: Regla personalizada ...
            'name' => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),
        ]); // ?: Le pasamos los datos al validador ...
        if ($validation->failed()) {
            return $response->withHeader('Location',  $routes->urlFor('auth.register'));// ?: Redireccionamos a la plantilla ...
        } //*: Comprobamos si los datos estan validados ...
        $usuario = new Usuarios(
            $params['name'],
            $params['email'],
            $params['password'],
        ); // ?: Creacion de un nuevo usuario ...
        try {
            $this->db->persist($usuario);
            $this->db->flush();
            // ?: Subir datos a la db ...
        } catch (\Doctrine\DBAL\Exception $exception) {
            echo $exception->getMessage();
        }
        // *: Redireccionamiento ...
        $response->getBody()->write('Usuario registrado con exito ...');
        return $response;
    }
}
