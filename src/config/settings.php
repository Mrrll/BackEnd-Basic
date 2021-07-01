<?php
use DI\Container;
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
                'metadata_dirs' => [__DIR__ . '/../src/app/app.php'],

                'connection' => [
                    'host' => 'localhost',
                    'user' => 'SYSTEM',
                    'password' => 'Ora69#LLmDB',
                    'port' => 1521,
                    'dbname' => 'securitywolfdb',
                    'service' => TRUE,
                    'servicename' => 'securitywolf',
                    'charset ' => 'UTF8',
                    'driver' => 'oci8',
                ],
            ],
        ];
    });
};
