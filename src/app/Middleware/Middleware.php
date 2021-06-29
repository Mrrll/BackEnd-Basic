<?php
namespace App\Middleware;
use Slim\App;
return function (App $app)
{
    $settings = $app->getContainer()->get('settings');
    $app->addErrorMiddleware(
        $settings['displayErrorDetails'],
        $settings['logErrorDetails'],
        $settings['logErrors'],
    ); //?: Convierte la salida de errores ...
};