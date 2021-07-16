<?php
// TODO: Archivo de rutas Slim ...
// *: Importamos las classes necesarias ...
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Middleware\Routes\AuthMiddleware;
use App\Middleware\Routes\GuestMiddleware;
use App\Middleware\Routes\VerificationEmailMiddleware;
// *: Creamos rutas ...
return function (App $app) {
    // *: Rutas web ...
    $app->get('/', 'IndexController:index')->setName('welcom');
    $app->get('/home', 'HomeController:index')->setName('home')->add(new AuthMiddleware($app->getContainer()))->add(new VerificationEmailMiddleware($app->getContainer()));
}; // ?: funcion de retorno y solicitud de la App ...
