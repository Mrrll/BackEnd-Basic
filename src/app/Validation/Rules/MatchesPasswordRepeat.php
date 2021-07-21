<?php
namespace App\Validation\Rules;
// TODO: Archivo de Regla Personalizada para la comparacion de passwords del formulario ...
// *: Importamos las classes necesarias ...
use Respect\Validation\Rules\AbstractRule;
final class MatchesPasswordRepeat extends AbstractRule
{
    protected $password;
    public function __construct($password)
    {
        $this->password = $password;
    }
    public function validate($input) : bool
    {
        return ($input === $this->password) ? true : false; // ?: Verifica magicamente las contraseñas ...
    }
}
