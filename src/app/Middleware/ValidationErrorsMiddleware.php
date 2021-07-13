<?php
namespace App\Middleware;
// TODO: Archivo que filtra la peticion del validador ...
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
class ValidationErrorsMiddleware extends Controller
{
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        if (isset($_SESSION['errors'])) {
            $this->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']); // ?: Pasamos datos a la vista ...
            unset($_SESSION['errors']); // ?: Eliminamos la session error ...
        }
        $response = $handler->handle($request);
        return $response;
    }
}
