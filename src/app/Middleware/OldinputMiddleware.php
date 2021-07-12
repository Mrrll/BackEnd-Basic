<?php
namespace App\Middleware;
// TODO: Archivo que recupera los datos de la peticion anterior ...
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
class OldinputMiddleware extends Middleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $params = (array)$request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        if (isset($_SESSION['old'])) {
            $this->view->getEnvironment()->addGlobal('old', $_SESSION['old']); // ?: Pasamos datos a la vista ...
        }
        $_SESSION['old'] = $params; // ?: Creamos la sesion old ...
        $response = $handler->handle($request);
        return $response;
    }
}
