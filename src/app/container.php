<?php
// TODO: Archivo de Configuracion de los Servicios del contenedor Slim ...
// *: Importamos las classes necesarias ...
use DI\Container;
use Slim\Views\Twig;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
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
        [__DIR__ . './'],
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
// *: Agregar servicio de IndexController a su contenedor ...
$container->set('IndexController', function ($container) {
    return new \App\Controllers\IndexController($container);
});
$container->set('RegisterController', function ($container) {
    return new \App\Controllers\Auth\RegisterController($container);
});