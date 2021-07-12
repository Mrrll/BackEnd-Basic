<?php
namespace App\Middleware;
class Middleware
{
    protected $container;
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