<?php
namespace App\Controllers\Auth\Mail;
// TODO: Archivo controlador de la password ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
class VerificationEmailController extends Controller
{
    public function index(Request $request, Response $response)
    {
        return $this->view->render($response, 'Auth/Mail/Verification.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
    public function VerificationEmail(Request $request, Response $response)
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $routes = RouteContext::fromRequest($request)->getRouteParser(); // ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
        if (
            !isset($_SESSION['verification']) ||
            !$this->csrf->validateToken(
                $_SESSION['verification'],
                $_GET['csrf_value']
            )
        ) {
            $this->flash->addMessage(
                'error',
                'The token is not valid or expired!'
            );
            return $response->withHeader(
                'Location',
                $routes->urlFor('auth.verification')
            ); // ?: Redireccionamos a la plantilla ...
        }
        $usuario = $this->auth->user(); // ?: Obtenemos el usuario con inicio de sesion ...
        // *: Actualizamos la fecha y la verificacion del email ...
        $usuario->setUpdateAt();
        $usuario->setEmailVerifiedAt();
        try {
            $this->db->persist($usuario);
            $this->db->flush(); // ?: Subir datos a la db ...
            unset($_SESSION['verification']);
            $this->flash->addMessage(
                'info',
                'The email verification was successful!'
            );
        } catch (\Doctrine\DBAL\Exception $exception) {
            // !: Esto hay que cambiarlo por un mensaje ...
            echo $exception->getMessage();
            // !: ------------------------------------------
        }
        // *: Redireccionamiento ...
        return $response->withHeader('Location', $routes->urlFor('home')); // ?: Redireccionamos a la plantilla ...
    }
}
