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
            return $this->db->getRepository(Usuarios::class)->find($_SESSION['user']);
        } // ?: Buscamos el usurio ....
        return false;
    } // ?: Buscamos si la sesion coicide con algun usuario de la tabla ...
    public function check()
    {
        return isset($_SESSION['user']); // ?: Miramos que la sesion exista ...
    } // ?: Comprobamos si hay sesion de usuraio ....
    public function attempt($email, $password)
    {
        $user = $this->db->getRepository(Usuarios::class)->findBy(array('email' => $email)); // ?: Buscamo el usuario por correo electrónico ...
        if (!$user) {
            return false;
        } // ?: Si el usuario no se encuentra devolvemos false ...
        if(password_verify($password, $user[0]->getPassword())){
            $_SESSION['user'] = $user[0]->getId(); // ?: Crear session de usuario ...
            return true;
        } // ?: Verificar contraseña para ese usuario ...
        return false;
    } // ?: Metodo que se encarga de verificar passwords ...
}
