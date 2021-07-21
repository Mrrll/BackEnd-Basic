<?php
namespace App\Middleware;
// TODO: Archivo de control de sesiones  ...
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
class SessionMiddleware extends Controller
{
    protected $setting;
    public function create($setting = [])
    {
        $defaults = [
            'lifetime' => '20 minutes',
            'name' => 'slim_session',
            'autorefresh' => false,
            'value' => '',
        ]; // ?: Parametros de configuracion de las sesiones por defecto ...
        $setting = array_merge($defaults, $setting); // ?: Une la configuracion ...
        // *: Convertimos el formato ...
        if (is_string($lifetime = $setting['lifetime'])) {
            $setting['time'] = $setting['lifetime'];
            if ($setting['autorefresh']) {
                $setting['time'] = 'Indefinite';
            }
            $setting['lifetime'] = strtotime($lifetime) - time();
        }
        // *: Creamos la sesion ...
        if (!isset($_SESSION[$setting['name']])) {
            $_SESSION[$setting['name']] = $setting['value'];
            // dd("Creamos la sesion del tiempo ");
        }
        // *: Creamos la sesion del tiempo ...
        if (!isset($_SESSION['CREATE_' . $setting['name']])) {
            $_SESSION['CREATE_' . $setting['name']] = time();
            // dd("Creamos la sesion del tiempo ");
        }
        // *: Creamos la sesion de ajustes ...
        if (!empty($_SESSION['SESSION'])) {
            foreach ($_SESSION['SESSION'] as $sesiones) {
                // *: Añadimos sesion al array de sesiones ...
                if (!array_search($setting['name'], $sesiones['setting'])) {
                    $_SESSION['SESSION'][] = [
                        'setting' => $setting,
                    ];
                }
            }
        } else {
            // *: Añadimos la configuracion de la sesion ...
            $_SESSION['SESSION'][] = [
                'setting' => $setting,
            ];
        }
        return $setting;
    }
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
    public function DeleteSession($name)
    {
        for ($i = 0; $i < count($_SESSION['SESSION']); $i++) {
            if ($_SESSION['SESSION'][$i]['setting']['name'] === $name) {
                // *: Borramos las sesiones ...
                    unset(
                        $_SESSION[
                            'CREATE_' .
                                $_SESSION['SESSION'][$i]['setting']['name']
                        ],
                        $_SESSION[$_SESSION['SESSION'][$i]['setting']['name']],
                        $_SESSION['SESSION'][$i]
                    );
                    sort($_SESSION['SESSION']);
            }
        }
        if (count($_SESSION['SESSION']) === 0) {
           unset($_SESSION['SESSION']);
        }
        return !isset($_SESSION[$name]);
    }
}
