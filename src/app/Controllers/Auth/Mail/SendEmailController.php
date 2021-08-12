<?php
namespace App\Controllers\Auth\Mail;
// TODO: Archivo controlador de los envios de email ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use Respect\Validation\Validator as v;
use App\Models\User;
class SendEmailController extends Controller
{
    public function SendVerificationEmail(Request $request, Response $response)
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $routes = RouteContext::fromRequest($request)->getRouteParser(); // ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
        if (!$this->auth->verification() && $this->auth->check()) {
            $user = $this->auth->user(); // ?: Obtenemos el usuario ...
            // *: Creacion del Token de acceso ...
            $sesionVerification = $this->session->create([
                'name' => 'verification',
                'value' => $this->csrf->getTokenName(),
                'lifetime' => '5 minutes',
            ]);
            // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Mail ) ...
            // *: Envio de Email ...
            $this->mailer->sendMessage(
                '/Auth/Mail/Templates/EmailVerification.twig',
                [
                    'user' => $user,
                    'token' => $this->csrf->getTokenValue(),
                ], // ?: Aqui añadimos datos a la vista ...
                function ($message) use ($user) {
                    $message->setTo($user->getEmail(), $user->getName());
                    $message->setSubject('Welcome to '.$_ENV['APP_NAME'].'!');
                }
            );
            // ! -------------------------------------------------------------------
            $this->flash->addMessage(
                'info',
                'Successful shipment, check your email to verify your credentials, The link will expire in ' .
                    $sesionVerification['time'] .
                    '.'
            );
            return $response->withHeader(
                'Location',
                $routes->urlFor('auth.verification')
            ); // ?: Redireccionamos a la plantilla ...
        }
        return $response;
    }
    public function SendChangePassword(Request $request, Response $response)
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $params = (array) $request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        $routes = RouteContext::fromRequest($request)->getRouteParser(); // ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()
                ->notEmpty()
                ->email()
                ->EmailCheck($this->container), // ?: Regla personalizada ...
        ]);
        if ($validation->failed()) {
            $this->flash->addMessage(
                'error',
                'The email does not match, check your data.'
            );
            return $response->withHeader(
                'Location',
                $routes->urlFor('auth.password.forgot')
            ); // ?: Redireccionamos a la plantilla ...
        } //*: Comprobamos si los datos estan validados ...

        if (isset($_SESSION['ValidationEmail'])) {
            $this->flash->addMessage(
                'warning',
                'You have an open recovery session.'
            );
            return $response->withHeader(
                'Location',
                $routes->urlFor('auth.password.forgot')
            ); // ?: Redireccionamos a la plantilla ...
        }
        // *: Creamos la sesion ...
        $sesionValidationEmail = $this->session->create([
            'name' => 'ValidationEmail',
            'value' => [
                'token' => $this->csrf->getTokenName(),
                'email' => $params['email']
            ],
            'lifetime' => '5 minutes',
        ]);
        $rep = $this->db->getRepository(User::class); // ?: Instanciamos la Clase ...
        $user = $rep->findBy(['email' => $params['email']]); // ?: Buscamos el usuario ...
        // *: Envio de Email ...
        $this->mailer->sendMessage(
            '/Auth/Mail/Templates/EmailForgot.twig',
            [
                'user' => $user[0],
                'token' => $this->csrf->getTokenValue(),
            ], // ?: Aqui añadimos datos a la vista ...
            function ($message) use ($user) {
                $message->setTo($user[0]->getEmail(), $user[0]->getName());
                $message->setSubject('Forgot Password to '.$_ENV['APP_NAME'] .'');
            }
        );
        $this->flash->addMessage(
            'info',
            'Successful shipment, check your email to verify your credentials, The link will expire in ' .
                $sesionValidationEmail['time'] .
                '.'
        );
        // *: Redireccionamiento ...
        return $response->withHeader(
            'Location',
            $routes->urlFor('auth.password.forgot')
        ); // ?: Redireccionamos a la plantilla ...
    }
}
