<?php
namespace App\Validation;
// TODO: Archivo de validacion de datos ...
// *: Importamos las clases necesarias ...
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\NestedValidationException;
class Validator
{
    protected $errors;
    // *: Metodo de validacion de datos ...
    public function validate(Request $request, array $rules)
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $params = (array)$request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        // ! -------------------------------------------------------------------
        foreach ($rules as $field => $rule) {
            try {
                $rule
                    ->setName(ucfirst($field))
                    ->assert($params[$field]); // ?: Validacion de los datos ...
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages(); // ?: Captura del mensaje de error de la validacion ...
            }
        }
        $_SESSION['errors'] = $this->errors; // ?: Creamos variable de session con el contenido de los errores generados ...
        return $this;
    }
    public function failed()
    {
        return !empty($this->errors); // ?: Valida si la variable errors contiene algun error ...
    }
}