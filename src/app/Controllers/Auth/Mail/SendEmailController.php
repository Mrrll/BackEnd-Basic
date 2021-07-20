<?php
namespace App\Controllers\Auth\Mail;
// TODO: Archivo controlador de los envios de email ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
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
                'lifetime' => '5 minutes'
            ]);
            // *: Envio de Email ...
            $this->mailer->sendMessage(
                '/Auth/Mail/Templates/EmailVerification.twig',
                [
                    'user' => $user,
                    'token' => $this->csrf->getTokenValue(),
                ], // ?: Aqui añadimos datos a la vista ...
                function ($message) use ($user) {
                    $message->setTo($user->getEmail(), $user->getName());
                    $message->setSubject('Welcome to the Team!');
                }
            );
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
}
