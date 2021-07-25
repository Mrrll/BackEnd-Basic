<?php
namespace App\Middleware;
// TODO: Archivo de control de sesiones  ...
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
class SessionMiddleware extends Controller
{
    public function __invoke(
        Request $request,
        RequestHandler $handler
    ): Response {
        // *: Verificamos si la sesion a caducado ...
        if (isset($_SESSION['SESSION'])) {
            for ($i = 0; $i < count($_SESSION['SESSION']); $i++) {
                if (
                    time() -
                        $_SESSION[
                            'CREATE_' .
                                $_SESSION['SESSION'][$i]['setting']['name']
                        ] >
                        $_SESSION['SESSION'][$i]['setting']['lifetime'] &&
                    !$_SESSION['SESSION'][$i]['setting']['autorefresh']
                ) {
                    // *: Borramos las sesiones ...
                    unset(
                        $_SESSION[
                            'CREATE_' .
                                $_SESSION['SESSION'][$i]['setting']['name']
                        ]
                    );
                    unset(
                        $_SESSION[$_SESSION['SESSION'][$i]['setting']['name']]
                    );
                    unset($_SESSION['SESSION'][$i]);
                    sort($_SESSION['SESSION']);
                    if (count($_SESSION['SESSION']) === 0) {
                       session_unset();
                       session_destroy();
                       break;
                    }
                } else {
                    // *: Actualizamos el tiempo ...
                    $_SESSION[
                        'CREATE_' . $_SESSION['SESSION'][$i]['setting']['name']
                    ] = time();
                }
            }
        }
        $response = $handler->handle($request);
        return $response;
    }
}
