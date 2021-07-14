<?php
// TODO: Archivo de rutas Slim ...
// *: Importamos las classes necesarias ...
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
// *: Creamos rutas ...
return function (App $app) {
    // *: Rutas web ...
    $app->get('/', 'IndexController:index')->setName('welcom');

    $app->group('guest', function () use ($app) {
        // *: Ruta del registro ...
        $app
            ->get('/register', 'RegisterController:index')
            ->setName('auth.register');
        $app->post('/register', 'RegisterController:register');
        // *: Ruta del login ...
        $app->get('/login', 'LoginController:index')->setName('auth.login');
        $app->post('/login', 'LoginController:login');
    })->add(new GuestMiddleware($app->getContainer()));
    // *: Rutas Auth ...
    $app
        ->group('auth', function () use ($app) {
            // *: Ruta web del usuario ...
            $app->get('/home', 'HomeController:index')->setName('home');
            // *: Ruta del logout ...
            $app
                ->get('/logout', 'LoginController:logout')
                ->setName('auth.logout');
            // *: Ruta del Cambio password ...
            $app
                ->get('/change', 'PasswordController:index')
                ->setName('auth.password.change');
            $app->post('/change', 'PasswordController:ChangePassword');
        })
        ->add(new AuthMiddleware($app->getContainer()));
}; // ?: funcion de retorno y solicitud de la App ...
