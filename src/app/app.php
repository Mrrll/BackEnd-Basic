<?php
use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once __DIR__ . '/../../vendor/autoload.php';
// Container de Slim ...
$container = new Container();
$settings = require_once __DIR__ . '/../config/settings.php';
$settings($container);

AppFactory::setContainer($container);
$app = AppFactory::create();
// Plantilla ...
// Create Twig ...
$twig = Twig::create(__DIR__ . '/../resources/Views', ['cache' => false]);
// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));
// Middleware salida 404 ...
$middleware = require_once __DIR__ . './Middleware/Middleware.php';
$middleware($app);

// Rutas ...
$routes = require_once __DIR__ . '/../resources/Routes/web.php';
$routes($app);

$app->run();