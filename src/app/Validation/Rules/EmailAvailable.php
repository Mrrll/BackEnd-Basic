<?php
namespace App\Validation\Rules;
// TODO: Archivo de Regla Personalizada para el Email ...
// *: Importamos las classes necesarias ...
use App\Models\User;
use Respect\Validation\Rules\AbstractRule;
final class EmailAvailable extends AbstractRule
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
        return count($this->db->getRepository(User::class)->findBy(array('email' => $input))) === 0;
    }
}
