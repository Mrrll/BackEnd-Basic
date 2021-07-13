<?php
namespace App\Validation\Exceptions;
// TODO: Archivo de excepcion de la regla personalizada del email ...
// *: Importamos las classes necesarias ...
use Respect\Validation\Exceptions\ValidationException;
final class EmailAvailableException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Email is already taken.',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => 'Validation message if the negative of Something is called and fails validation.',
        ],
    ]; // ?: Declara mensajes para devolver ...
}