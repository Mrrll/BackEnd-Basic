<?php
namespace App\Services;
// TODO: Archivo de control de Cookies  ...
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
class Cookie extends Controller
{
    protected $setting;
    public function create($setting = [])
    {
        $defaults = [
            'name' => 'cookie_session',
            'value' => '',
            'expires' => '20 minutes',
            'path' => '/',
            'domain' => 'localhost',
            'secure' => true,
            'httponly' => false,
        ]; // ?: Parametros de configuracion de las sesiones por defecto ...
        $setting = array_merge($defaults, $setting); // ?: Une la configuracion ...
        // *: Convertimos el formato ...
        if (is_string($lifetime = $setting['expires'])) {
            $setting['expires'] = time() + (strtotime($lifetime) - time());
        }
        // *: Creamos la sesion ...
        if (!isset($_COOKIE[$setting['name']])) {
            setcookie(
                $setting['name'],
                password_hash($setting['value'], PASSWORD_BCRYPT),
                $setting['expires'],
                $setting['path'],
                $setting['domain'],
                $setting['secure'],
                $setting['httponly']
            );
        }
        return $setting;
    }
    public function DeleteCookie($name)
    {
        setcookie($name, '', time() - 600);
        return !isset($_COOKIE[$name]);
    }
}
