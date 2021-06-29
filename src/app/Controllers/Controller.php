<?php
namespace App\Controllers;
// TODO: Archivo controlador base de controladores ...
class Controller
{
    protected $container;
    // *: Constructor de objeto container ...
    public function __construct($container)
    {
        $this->container = $container;
    }
    // *: Metodo get del objeto container ...
    public function __get($property)
    {
        // ?: Devuelve la propiedad del objeto container solicitada ...
        if ($this->container->get($property)) {
            return $this->container->get($property);
        }
    }
}
