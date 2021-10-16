# BackEnd-Basic
BackEnd básico hecho con Slim, Doctrine y Twig en PHP v7.3

## Instalación ...
>Abra la terminal y tipeé :
```console
composer up 
```
Una vez instalado ya está listo para su configuración...

## Configuración ...

>Creamos el archivo <code>.env</code> en la raíz del proyecto <code>./</code>

Una vez creado el archivo.
>Copiamos y pegamos el contenido del archivo <code>.env.example</code> 
>en el archivo <code>.env</code> que acabamos de crear. 

Rellenamos los datos de configuración.

### Database:
>Creamos la base de datos con el nombre que hemos proporcionado en la variable <code>DATABASE_NAME</code> en el <code>.env</code>

**`Nota:` 
La base de datos debe estar con el motor InnoDB y no debe contener ninguna tabla.**
#### Creamos las tablas: 
>Abra la terminal y tipeé :
```console
./vendor/bin/doctrine-migrations :migrate
```
>Tipeamos `yes` Cuando aparezca : WARNING! You are about to execute a migration in database "DATABASE_NAME" that could result in schema changes and data loss. Are you sure you wish to continue? (yes/no) [yes]:

## Ejecución ...
```code
php -S localhost:8080 -t public
```
# Uso ...
<a name="top"></a>

## Índice de contenidos

- [Creando una nueva vista](#item1)
- [Creando una nueva Regla de Validacion](#item2)

<a name="item1"></a>
### Creando una nueva vista:
#### Vista:
>Creamos el archivo <code>about.twig</code> en <code>./src/resources/Views/</code> y añadimos el siguiente codigo.
```twig
{% extends 'Templates/app.twig' %}

{% block content %}
  About !!!
{% endblock %}
```
#### Controlador:
>Creamos el archivo <code>AboutController.php</code> en <code>./src/app/Controllers/</code> y añadimos el siguiente codigo.
```php
<?php
namespace App\Controllers;
// TODO: Archivo de Controlador de la vista About ...
class AboutController extends Controller
{
    // *: Muestra la peticion get del controlador ...
    public function index($request, $response)
    {
        return $this->view->render($response, 'about.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
}
```
#### Añadimos Controlador:
>Abrimos el archivo <code>controllers.php</code> en <code>./src/app/config/</code> y añadimos el siguiente codigo.
```php
$container->set('AboutController', function ($container) {
    return new \App\Controllers\AboutController($container);
});
```
#### Ruta:
>Abrimos el archivo <code>web.php</code> en <code>./src/resources/Routes/</code> y añadimos el siguiente codigo dentro del a funcion `return function (App $app) {`.
```php
$app->get('/about', 'AboutController:index')->setName('about');
```
#### Navegación:
>Abrimos el archivo <code>nav.twig</code> en <code>./src/resources/Views/Templates/Layouts/</code> debajo del bloque:`{% if auth.check %} <li class="nav-item"> <a class="nav-link active" aria-current="page" href="{{ url_for('home') }}">Home</a>  </li> {% endif %}`

>Añadimos el siguiente codigo:


```twig
<li class="nav-item">
  <a class="nav-link active" aria-current="page" href="{{ url_for('about') }}">About</a>
</li>
```
>Pues eso es todo espero que sirva. 👍
[Subir](#top)

<a name="item2"></a>
## Creando una nueva Regla de Validacion:
### Archivo de validacion
>Creamos el archivo `EmailAvailable.php` en `./src/app/Validation/Rules/` y añadimos el siguiente codigo.
```php
<?php
namespace App\Validation\Rules;
// TODO: Archivo de Regla Personalizada para el Email ...
// *: Importamos las classes necesarias ...
use App\Models\User;
use Respect\Validation\Rules\AbstractRule;
final class EmailAvailable extends AbstractRule
{   
    public function __construct($container)
    {
        $this->container = $container;
    }    
    public function __get($property)
    {        
        if ($this->container->get($property)) {
            return $this->container->get($property);
        }
    }    
    public function validate($input) : bool
    {
        // ?: Valida si el email ya esta registrado ...
        return count($this->db->getRepository(User::class)->findBy(array('email' => $input))) === 0;
    }
}

```
### Archivo de Excepcion
>Creamos el archivo `EmailAvailableException.php` en `./src/app/Validation/Exception/` y añadimos el siguiente codigo.
```php
<?php
namespace App\Validation\Exceptions;
// TODO: Archivo de excepcion de la regla personalizada del email ...
// *: Importamos las classes necesarias ...
use Respect\Validation\Exceptions\ValidationException;
final class EmailAvailableException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Email is already taken.',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => 'Validation message if the negative of Something is called and fails validation.',
        ],
    ]; // ?: Declara mensajes para devolver ...
}
```
### Uso ...
```php
use Respect\Validation\Validator as v;
$validation = $this->validator->validate($request, [
   'email' => v::emailAvailable($this->container), // ?: Regla personalizada ...
]);
```
>Pues eso es todo espero que sirva. 👍
[Subir](#top)
