<?php
namespace App\Controllers\Auth\Secure;
// TODO: Archivo controlador el Forgot password ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use Slim\Routing\RouteContext;
use App\Models\User;
class ForgotPasswordController extends Controller
{
    public function index(Request $request, Response $response)
    {
        return $this->view->render($response, 'Auth/Secure/forgot.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
    public function VerificateForgot(Request $request, Response $response)
    {
        $routes = RouteContext::fromRequest($request)->getRouteParser(); // ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // *: Validamos el token devuelto ...
        if (
            !isset($_SESSION['ValidationEmail']) ||
            !$this->csrf->validateToken(
                $_SESSION['ValidationEmail']['token'],
                $_GET['csrf_value']
            )
        ) {
            $this->flash->addMessage(
                'error',
                'The token is not valid or expired!'
            );
            return $response->withHeader(
                'Location',
                $routes->urlFor('auth.password.forgot')
            ); // ?: Redireccionamos a la plantilla ...
        }

        return $response->withHeader(
            'Location',
            $routes->urlFor('auth.password.forgot.change')
        ); // ?: Redireccionamos a la plantilla ...
    }
    public function RenderChange(Request $request, Response $response)
    {
        if (isset($_SESSION['ValidationEmail'])) {
            $this->view->getEnvironment()->addGlobal('email', [
                'field' =>
                    '
                    <input type="hidden" name="email" value="' .
                    $_SESSION['ValidationEmail']['email'] .
                    '">
                ',
            ]); // ?: Enviamos a la vista los imputs ocultos ...

            return $this->view->render(
                $response,
                'Auth/Mail/forgotchange.twig'
            ); // ?: Renderizamos la plantilla desde el contenedor view ...
        }
        $this->flash->addMessage('error', 'The token is not valid or expired!');
        return $this->view->render($response, 'Auth/Secure/forgot.twig');
    }
    public function ChangePassword(Request $request, Response $response)
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $params = (array) $request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        $routes = RouteContext::fromRequest($request)->getRouteParser(); // ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
        // *: Validación de datos ...
        $validation = $this->validator->validate($request, [
            'password' => v::noWhitespace()->notEmpty(),
            'password_re' => v::noWhitespace()
                ->notEmpty()
                ->matchesPasswordRepeat($params['password']), // ?: Regla personalizada ...,
        ]);
        if ($validation->failed()) {
            return $response->withHeader(
                'Location',
                $routes->urlFor('auth.password.forgot.change')
            ); // ?: Redireccionamos a la plantilla ...
        } //*: Comprobamos si los datos estan validados ...
        $this->session->DeleteSession('ValidationEmail'); // ?: Eliminamos la sesion ...
        $rep = $this->db->getRepository(User::class); // ?: Instanciamos la Clase ...
        $usuario = $rep->findBy(['email' => $params['email']])[0]; // ?: Buscamos el usuario ...
        $usuario->setPassword($params['password']); // ?: Añadimos la nueva password ...
        try {
            $this->db->persist($usuario);
            $this->db->flush(); // ?: Subir datos a la db ...
            $this->auth->attempt($usuario->getEmail(), $params['password']); // ?: Llamamos al metodo del clase auth y le pasamos el email y password ...
            $this->flash->addMessage('info', 'The password has been changed!');
        } catch (\Doctrine\DBAL\Exception $exception) {
            // !: Esto hay que cambiarlo por un mensaje ...
            echo $exception->getMessage();
            // !: ------------------------------------------
        }
        // *: Redireccionamiento ...
        return $response->withHeader('Location', $routes->urlFor('home')); // ?: Redireccionamos a la plantilla ...
    }
}
