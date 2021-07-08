<?php
// TODO: Archivo de Servicios de los Controladores para el contenedor Slim ...
// *: Agregar servicio de IndexController a su contenedor ...
$container->set('IndexController', function ($container) {
    return new \App\Controllers\IndexController($container);
});
$container->set('RegisterController', function ($container) {
    return new \App\Controllers\Auth\RegisterController($container);
});