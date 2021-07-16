<?php
// TODO: Archivo de Servicios de los Controladores para el contenedor Slim ...
// *: Agregar servicio de IndexController a su contenedor ...
$container->set('IndexController', function ($container) {
    return new \App\Controllers\IndexController($container);
});
$container->set('HomeController', function ($container) {
    return new \App\Controllers\HomeController($container);
});
$container->set('RegisterController', function ($container) {
    return new \App\Controllers\Auth\RegisterController($container);
});
$container->set('LoginController', function ($container) {
    return new \App\Controllers\Auth\LoginController($container);
});
$container->set('PasswordController', function ($container) {
    return new \App\Controllers\Auth\Secure\PasswordController($container);
});
$container->set('VerificationEmailController', function ($container) {
    return new \App\Controllers\Auth\Mail\VerificationEmailController($container);
});
