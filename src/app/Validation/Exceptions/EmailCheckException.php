<?php
namespace App\Validation\Exceptions;
// TODO: Archivo de excepcion de la regla personalizada del email que mira si hay un email igual ...
// *: Importamos las classes necesarias ...
use Respect\Validation\Exceptions\ValidationException;
final class EmailCheckException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'The email does not match.',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => 'Validation message if the negative of Something is called and fails validation.',
        ],
    ]; // ?: Declara mensajes para devolver ...
}