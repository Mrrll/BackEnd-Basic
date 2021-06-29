<?php
use DI\Container;
return function (Container $container)
{
    $container->set('settings', function ()
    {
        return [
            'displayErrorDetails' => true,
            'logErrorDetails' => true,
            'logErrors' => true
        ];
    });
};