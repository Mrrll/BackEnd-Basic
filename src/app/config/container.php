<?php
// TODO: Archivo de Configuracion de los Servicios del contenedor Slim ...
require_once __DIR__ . "/../../../vendor/autoload.php";
// *: Importamos las classes necesarias ...
use DI\Container;
use Slim\Views\Twig;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
// *: Agregar servicio de Doctrine a su contenedor ...
$container->set(EntityManager::class, static function (
    Container $container
): EntityManager {
    $settings = $container->get('settings'); // ?: obtener parametros de configuracion ...
    // *: Parametros de configuracion AnnotationMetadata ...
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
    ); // ?: Metodo de configuracion de doctrine ...
    return EntityManager::create($settings['doctrine']['connection'], $config); // ?: Creamos y devolvemos la instancia ...
});
// *: Agregar servicio puente de Doctrine db ...
$container->set('db', function ($container)
{
   return $container->get(EntityManager::class);
});
// *: Agregar servicio de vista a su contenedor ...
$container->set('view', function ($container) {
    // *: Motor de Plantilla Twig ...
    return Twig::create(__DIR__ . '/../../resources/Views', ['cache' => false]);
});
require_once __DIR__ . "./controllers.php";