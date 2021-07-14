<?php
namespace App\Validation\Exceptions;
// TODO: Archivo de excepcion de la regla personalizada del Matches Password ...
// *: Importamos las classes necesarias ...
use Respect\Validation\Exceptions\ValidationException;
final class MatchesPasswordException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Password does not match.',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => 'Validation message if the negative of Something is called and fails validation.',
        ],
    ]; // ?: Declara mensajes para devolver ...
}