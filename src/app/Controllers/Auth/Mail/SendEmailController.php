<?php
namespace App\Controllers\Auth\Mail;
// TODO: Archivo controlador de los envios de email ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use Slim\Routing\RouteContext;
class SendEmailController extends Controller
{
    public function SendEmail(Request $request, Response $response)
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $params = (array)$request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
        $user = $this->auth->user(); // ?: Obtenemos el usuario ...
        // *: Envio de Email ...
        $this->mailer->sendMessage(
            '/Auth/Mail/Templates/EmailVerification.twig',
            ['user' => $user], // ?: Aqui añadimos el usuario a la vista ...
            function ($message) use ($user) {
                $message->setTo($user->getEmail(), $user->getName());
                $message->setSubject('Welcome to the Team!');
            }
        );
        $this->flash->addMessage('info', 'Successful shipment, check your email to verify your credentials.');
        return $response->withHeader('Location',  $routes->urlFor('auth.verification'));// ?: Redireccionamos a la plantilla ...
    }
}
