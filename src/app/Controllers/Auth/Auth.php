<?php
namespace App\Controllers\Auth;
// TODO: Archivo que comprueba las credenciales del usurario ...
// *: Importamos las classes necesarias ...
use App\Models\Usuarios;
use App\Controllers\Controller;
class Auth extends Controller
{
    public function user()
    {
        if (isset($_SESSION['user'])) {
            return $this->db
                ->getRepository(Usuarios::class)
                ->find($_SESSION['user']);
        } // ?: Buscamos el usurio ....
        return false;
    } // ?: Buscamos si la sesion coicide con algun usuario de la tabla ...
    public function check()
    {
        return isset($_SESSION['user']); // ?: Miramos que la sesion exista ...
    } // ?: Comprobamos si hay sesion de usuraio ....
    public function attempt($email, $password, $remember = null)
    {
        $user = $this->db
            ->getRepository(Usuarios::class)
            ->findBy(['email' => $email]); // ?: Buscamo el usuario por correo electrónico ...
        if (!$user) {
            return false;
        } // ?: Si el usuario no se encuentra devolvemos false ...
        if (password_verify($password, $user[0]->getPassword())) {
            $this->session->create([
                'name' => 'user',
                'value' => $user[0]->getId(),
            ]); // ?: Crear session de usuario ...
            if ($remember) {
                $this->cookies->create([
                    'name' => 'remember_user_session',
                    'value' => $email,
                    'expires' => '1 minutes',
                ]);
            }
            return true;
        } // ?: Verificar contraseña para ese usuario ...
        return false;
    } // ?: Metodo que se encarga de verificar passwords ...
    public function logout()
    {
        if (isset($_COOKIE['remember_user_session'])) {
            $this->cookies->DeleteCookie('remember_user_session');
        }
        session_unset();
        session_destroy();
    }
    public function verification()
    {
        // *: Funcion de la Verificacion del Email ...
        if (isset($_SESSION['user'])) {
            $rep = $this->db->getRepository(Usuarios::class); // ?: Instanciamos la Clase ...
            $usu = $rep->findBy(['email' => $this->auth->user()->getEmail()]); // ?: Buscamos el usuario con inicio de sesion ...
            if ($usu[0]->getEmailVerifiedAt()) {
                return true;
            } // ? Si es verdadero devolvemos true ...
        } // ?: Buscamos el usurio ....
        return false;
    }
    public function attemptRemember()
    {
        $user = $this->db
            ->getRepository(Usuarios::class)
            ->findBy(['rememmber_me' => $_COOKIE['remember_user_session']]); // ?: Buscamo el usuario por correo electrónico ...
        if (!$user) {
            return false;
        } // ?: Si el usuario no se encuentra devolvemos false ...
        if (password_verify($user[0]->getEmail(), $_COOKIE['remember_user_session'])) {
            $this->session->create([
                'name' => 'user',
                'value' => $user[0]->getId(),
            ]); // ?: Crear session de usuario ...
            return true;
        } // ?: Verificar contraseña para ese usuario ...
        return false;
    } // ?: Metodo que se encarga de verificar passwords ...
}
