<?php
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../../vendor/autoload.php';
// Container de Slim ...
$container = new Container();
$settings = require_once __DIR__ . '/../config/settings.php';
$settings($container);

AppFactory::setContainer($container);
$app = AppFactory::create();
// Middleware salida 404 ...
$middleware = require_once __DIR__ . './Middleware/Middleware.php';
$middleware($app);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->run();