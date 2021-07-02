<?php
// TODO: Archivo de inicializacion y configuracion inicial de la aplicacion La Aplicación, (o Slim\App) es el punto de entrada a su aplicación Slim y se utiliza para registrar las rutas que enlazan con sus devoluciones de llamada o controladores ...
// *: Importamos las classes necesarias ...
use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
// *: Importamos el Autoload de las classes ...
require_once __DIR__ . '/../../vendor/autoload.php';
//* Container de Slim DI ...
$container = new Container();
$settings = require_once __DIR__ . '/../config/settings.php';
$settings($container); // ?: Añadimos al contenedor ...
// *: Crear App con la Fabrica Slim ...
AppFactory::setContainer($container); // ?: Añadimos a la aplicacion ...
$app = AppFactory::create(); // ?: Creamos la instancia app ...

// *: Agregar servicio de Doctrine a su contenedor ...
$container->set(EntityManager::class, static function (
    Container $container
): EntityManager {
    $settings = $container->get('settings');

    $isDevMode = true;
    $proxyDir = null;
    $cache = null;
    $useSimpleAnnotationReader = false;
    $config = Setup::createAnnotationMetadataConfiguration(
        [__DIR__ . '/src'],
        $isDevMode,
        $proxyDir,
        $cache,
        $useSimpleAnnotationReader
    );

    return EntityManager::create($settings['doctrine']['connection'], $config);
});
// *: Agregar servicio de vista a su contenedor ...
$container->set('view', function ($container) {
    // *: Motor de Plantilla Twig ...
    return Twig::create(__DIR__ . '/../resources/Views', ['cache' => false]);
});
// *: Añadir Twig-View Middleware ...
$app->add(TwigMiddleware::create($app, $container->get('view')));
// *: Agregar servicio de IndexController a su contenedor ...
$container->set('IndexController', function ($container) {
    return new \App\Controllers\IndexController($container);
});
$container->set('RegisterController', function ($container) {
    return new \App\Controllers\Auth\RegisterController($container);
});
// *: Middleware salida 404 ...
$middleware = require_once __DIR__ . './Middleware/Middleware.php';
$middleware($app);
// *: Rutas ...
$routes = require_once __DIR__ . '/../resources/Routes/web.php';
$routes($app);
// *: Arrancamos la app ...
$app->run();
