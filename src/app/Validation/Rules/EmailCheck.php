<?php
namespace App\Validation\Rules;
// TODO: Archivo de Regla Personalizada del email que mira si hay un email igual ...
// *: Importamos las classes necesarias ...
use App\Models\Usuarios;
use Respect\Validation\Rules\AbstractRule;
final class EmailCheck extends AbstractRule
{
    // !: Esta parte ya esta metida en Controllers pero para poder acceder a ella ( Me visto obligado a duplicarla ) ...
    // *: Metodo get del objeto container ...
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
    // ! -------------------------------------------------------------------
    public function validate($input) : bool
    {
        // ?: Valida si el email ya esta registrado ...
        return count($this->db->getRepository(Usuarios::class)->findBy(array('email' => $input))) === 1;
    }
}
