<?php
namespace App\Controllers\Auth;
// TODO: Archivo controlador base de controladores de authentication ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use App\Models\Usuarios;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\DateTime;
class RegisterController extends Controller
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'Auth/register.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
    public function register(Request $request, Response $response)
    {
        $params = (array)$request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        // $usuarios = $this->db->getRepository(Usuarios::class)->findBy(array('name' => $params['name']));
        // foreach ($usuarios as $usuario) :
        //     // PHP_EOL fin de linea ...
        //     echo 'Nombre : ' . $usuario->getName(), PHP_EOL;
        //     $usuario->setName('Pablo');
        // endforeach;

        // die();
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
