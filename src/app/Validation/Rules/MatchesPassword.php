<?php
namespace App\Validation\Rules;
// TODO: Archivo de Regla Personalizada para la comparacion de passwords ...
// *: Importamos las classes necesarias ...
use Respect\Validation\Rules\AbstractRule;
final class MatchesPassword extends AbstractRule
{
    protected $password;
    public function __construct($password)
    {
        $this->password = $password;
    }
    public function validate($input) : bool
    {
        return password_verify($input, $this->password); // ?: Verifica magicamente las contraseñas ...
    }
}
