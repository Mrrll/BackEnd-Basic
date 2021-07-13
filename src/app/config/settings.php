<?php
use DI\Container;
use \Dotenv\Dotenv;
// *: Carga las variables de entorno ...
Dotenv::createImmutable(__DIR__ . '/../../../')->load();
return function (Container $container) {
    $container->set('settings', function () {
        return [
            'displayErrorDetails' => true,
            'logErrorDetails' => true,
            'logErrors' => true,
            'doctrine' => [
                // if true, metadata caching is forcefully disabled
                'dev_mode' => true,

                // path where the compiled metadata info will be cached
                // make sure the path exists and it is writable
                'cache_dir' => __DIR__ . '/../cache/doctrine',
                // you should add any other path containing annotated entity classes
                'metadata_dirs' => [__DIR__ . '/../src/app/Models'],

                'connection' => [
                    'dbname' => $_ENV[ 'DATABASE_NAME' ],
                    'user' => $_ENV[ 'DATABASE_USER' ],
                    'password' => $_ENV[ 'DATABASE_PASSWD' ],
                    'host' => $_ENV[ 'DATABASE_HOST' ],
                    'driver' => $_ENV[ 'DATABASE_DRIVER' ],
                ],
            ],
        ];
    });
};
