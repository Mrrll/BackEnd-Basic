<?php
namespace App\Services;
// TODO: Archivo de control de Cookies  ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
class Cookie extends Controller
{
    protected $setting;
    public function create($setting = [])
    {
        $defaults = [
            'name' => 'cookie_session',
            'value' => '',
            'expires' => '1 year',
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
        // *: Encriptamos valor ...
        if (is_string($valCrypt = $setting['value'])) {
            $setting['value'] = password_hash($valCrypt, PASSWORD_BCRYPT);
        }
        // *: Creamos la sesion ...
        if (!isset($_COOKIE[$setting['name']])) {
            setcookie(
                $setting['name'],
                 $setting['value'],
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
