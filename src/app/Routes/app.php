<?php
// TODO: Archivo de rutas de la App Slim ...
// *: Importamos las classes necesarias ...
use Slim\App;
use App\Middleware\Routes\AuthMiddleware;
use App\Middleware\Routes\GuestMiddleware;
use App\Middleware\Routes\VerificationEmailMiddleware;
use App\Middleware\Routes\EmailVerificateMiddleware;
// *: Creamos rutas ...
return function (App $app) {
    // *: Rutas Guest ...
    $app
        ->group('guest', function () use ($app) {
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
            // *: Ruta del forgot ...
            $app->get('/password/forgot', 'ForgotPasswordController:index')->setName('auth.password.forgot');
            $app->post('/password/forgot', 'SendEmailController:SendChangePassword');
            $app->get('/verification/password/forgot', 'ForgotPasswordController:VerificateForgot')->setName('auth.password.forgot.verification');
            $app->get('/password/forgot/change', 'ForgotPasswordController:RenderChange')->setName('auth.password.forgot.change');
            $app->post('/password/forgot/change', 'ForgotPasswordController:ChangePassword');
        })
        ->add(new GuestMiddleware($app->getContainer()));
    // *: Rutas Auth ...
    $app
        ->group('auth', function () use ($app) {
            // *: Ruta del Cambio password ...
            $app
                ->get('/change', 'PasswordController:index')
                ->setName('auth.password.change')
                ->add(new VerificationEmailMiddleware($app->getContainer()));
            $app->post('/change', 'PasswordController:ChangePassword');
        })
        ->add(new AuthMiddleware($app->getContainer()));
    // *: Rutas Verification ...
    $app->group('verification', function () use ($app) {
        // *: Ruta de la Verificacion de Email ...
        $app
            ->get('/verification', 'VerificationEmailController:index')
            ->setName('auth.verification');
        $app
            ->get(
                '/verification/auth/',
                'VerificationEmailController:VerificationEmail'
            )
            ->setName('auth.verification.check');
        // *: Ruta del Envio de Email ...
        $app
            ->get('/verification/auth/send', 'SendEmailController:SendVerificationEmail')
            ->setName('auth.verification.send');
    })->add(new AuthMiddleware($app->getContainer()))
    ->add(new EmailVerificateMiddleware($app->getContainer()));
}; // ?: funcion de retorno y solicitud de la App ...
