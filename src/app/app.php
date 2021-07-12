<?php
// TODO: Archivo de inicializacion y configuracion inicial de la aplicacion La Aplicación, (o Slim\App) es el punto de entrada a su aplicación Slim y se utiliza para registrar las rutas que enlazan con sus devoluciones de llamada o controladores ...
// *: Importamos las classes necesarias ...
use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
session_start();
// *: Importamos el Autoload de las classes ...
require_once __DIR__ . '/../../vendor/autoload.php';
// *: Importamos los helpers personalizados ...
require_once __DIR__ . "./Helpers/Helper.php";
//* Container de Slim DI ...
$container = new Container();
$settings = require_once __DIR__ . './config/settings.php';
$settings($container); // ?: Añadimos al contenedor ...
// *: Crear App con la Fabrica Slim ...
AppFactory::setContainer($container); // ?: Añadimos a la aplicacion ...
$app = AppFactory::create(); // ?: Creamos la instancia app ...
// *: Importamos los servicios del contenedor ...
require_once __DIR__ . './config/container.php';
// *: Añadir Twig-View Middleware ...
$app->add(TwigMiddleware::create($app, $container->get('view')));
// $app->add(TwigMiddleware::createFromContainer($app));
// *: Middleware salida 404 ...
$middleware = require_once __DIR__ . './Middleware/MiddlewareErrors.php';
$middleware($app);
// *: Middleware de Validaciones ...
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldinputMiddleware($container));
// *: Rutas ...
$routes = require_once __DIR__ . '/../resources/Routes/web.php';
$routes($app);
