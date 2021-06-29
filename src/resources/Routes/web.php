<?php
// TODO: Archivo de rutas Slim ...
// *: Importamos las classes necesarias ...
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
// *: Creamos rutas ...
return function (App $app)
{
    $app->get('/', 'IndexController:index')->setName('welcom');
    $app->get('/register', 'RegisterController:index')->setName('auth.register');
}; // ?: funcion de retorno y solicitud de la App ...