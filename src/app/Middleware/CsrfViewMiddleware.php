<?php
namespace App\Middleware;
// TODO: Archivo que gestiona el Token Csrf ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
class CsrfViewMiddleware extends Controller
{
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        $this->view->getEnvironment()->addGlobal('csrf', [
            'field' => '
                <input type="hidden" name="'.$this->csrf->getTokenNameKey() .'" value="'.$this->csrf->getTokenName() .'">
                <input type="hidden" name="'.$this->csrf->getTokenValueKey() .'" value="'.$this->csrf->getTokenValue() .'">
            ',
        ]); // ?: Enviamos a la vista los imputs con los tokens generados ...
        $response = $handler->handle($request);
        return $response;
    }
}
