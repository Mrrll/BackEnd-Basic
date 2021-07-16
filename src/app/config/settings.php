<?php
// TODO: Archivo para añadir configuraciones a la aplicacion slim ...
// *: Importamos las classes necesarias ...
use DI\Container;
use Dotenv\Dotenv;
// *: Carga las variables de entorno ...
Dotenv::createImmutable(__DIR__ . '/../../../')->load();
return function (Container $container) {
    $container->set('settings', function () {
        return [
            'displayErrorDetails' => true,
            'logErrorDetails' => true,
            'logErrors' => true,
            'doctrine' => [
                'dev_mode' => true, // ?: if true, el almacenamiento en caché de metadatos se deshabilita por la fuerza ...
                'cache_dir' => __DIR__ . '/../cache/doctrine', // ?: Ruta donde se almacenará en caché la información de metadatos compilados, asegúrese de que la ruta exista y se pueda escribir ...
                'metadata_dirs' => [__DIR__ . '/../src/app/Models'], // ?: Ruta que contenga las clases de entidad anotadas ...
                'connection' => [
                    'dbname' => $_ENV['DATABASE_NAME'], // ?: DataBase Name
                    'user' => $_ENV['DATABASE_USER'], // ?: DataBase Username
                    'password' => $_ENV['DATABASE_PASSWD'], // ?: DataBase Password
                    'host' => $_ENV['DATABASE_HOST'], // ?: DataBase Host
                    'driver' => $_ENV['DATABASE_DRIVER'], // ?: DataBase Driver
                ],
            ],
            'mailer' => [
                'host' => $_ENV['SMTP_HOST'], // ?: SMTP Host
                'port' => $_ENV['SMTP_PORT'], // ?: SMTP Port
                'username' => $_ENV['SMTP_USER'], // ?: SMTP Username
                'password' => $_ENV['SMTP_PASSWD'], // ?: SMTP Password
                'protocol' => $_ENV['SMTP_PROTOCOL'], // ?: SSL or TLS
            ],
        ];
    });
};
