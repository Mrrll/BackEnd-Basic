<?php
// TODO: Archivo de rutas de la App Slim ...
// *: Importamos las classes necesarias ...
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Middleware\Routes\AuthMiddleware;
use App\Middleware\Routes\GuestMiddleware;
use App\Middleware\Routes\VerificationEmailMiddleware;
// *: Creamos rutas ...
return function (App $app) {
    $app->group('guest', function () use ($app) {
        // *: Ruta del registro ...
        $app
            ->get('/register', 'RegisterController:index')
            ->setName('auth.register');
        $app->post('/register', 'RegisterController:register');
        // *: Ruta del login ...
        $app->get('/login', 'LoginController:index')->setName('auth.login');
        $app->post('/login', 'LoginController:login');
        // *: Ruta del logout ...
            $app
                ->get('/logout', 'LoginController:logout')
                ->setName('auth.logout');
    })->add(new GuestMiddleware($app->getContainer()));
    // *: Rutas Auth ...
    $app
        ->group('auth', function () use ($app) {

            // *: Ruta del Cambio password ...
            $app
            ->get('/change', 'PasswordController:index')
            ->setName('auth.password.change')->add(new VerificationEmailMiddleware($app->getContainer()));
            $app->post('/change', 'PasswordController:ChangePassword');
            // *: Ruta de la Verificacion de Email ...
            $app->get('/verification', 'VerificationEmailController:index')->setName('auth.verification');
            $app->get('/verification/auth', 'VerificationEmailController:VerificationEmail')->setName('auth.verification.check');
            // *: Ruta del Envio de Email ...
            $app->get('/verification/auth/send', 'SendEmailController:SendEmail')->setName('auth.verification.send');
        })
        ->add(new AuthMiddleware($app->getContainer()));
}; // ?: funcion de retorno y solicitud de la App ...
