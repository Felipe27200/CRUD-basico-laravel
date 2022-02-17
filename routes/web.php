<?php

use Illuminate\Support\Facades\Route;

/* Aquí importamos el contralador de Empleado, 
para poder hacer uso de sus métodos y propiedades */
use App\Http\Controllers\EmpleadoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

/* Se recibe la Url por default así
si se escribe localhost/sistema/public/empleado
 en el navegador, debe redirigir a empleado.index,
 
 El primer parárametro indica la carpeta en \views en la
 que está la vista y en la función del segundo parámetro,
 el return devuelve la vista que se solicito */
// Route::get('/empleado', function () {
//     return view('empleado.index');
// });

/* <<< FORMA ALTERNATIVA PARA ACCEDER MEDIANTE EL USO DE CLASES >>> */

/* Se usan los métodos del controlador para acceder y redirigir desde
él a la vista adecuada

Parámetros
1. recibe la ruta a la que el usuario accede en 
localhost/sistema/public/empleado/create

2. El segundo es un array en el que su primer elemento indica 
que se va acceder a la clase y el segundo elemento es el método
de la clase que se va a invocar
*/

// Route::get('empleado/create', [EmpleadoController ::class, 'create']);

// *** ACCEDER DE MEDIANTE UN MÉTODO A TODAS LAS VISTAS ***

// De esta forma se obtienen todas las rutas
// relacionadas al modelo de empleado

/* Así se puede acceder a todas las vistas con las url ya vistas, sin afectar
el redireccionamiento, ya que hace automáticamente la busque de la url.

Se debe tener en cuenta que si en los métodos de EmpleadoController, 
exceptuando index(), no se define la redirección, entonces esta no 
ocurrira si se usa está forma => Error 404 */

/* Así se le indica que primero respete la autenticación, antes de
redireccionar */
Route::resource('empleado', EmpleadoController::class)->middleware('auth');

// con el array se indica respectivamente que oculte el link para registrarse y
// para recuperar la contraseña
Auth::routes(['register' => false, 'reset' => false]);

/* Se debe eliminar esta línea, ya que se debe dirigir a EmpleadoController
 Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');*/
Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

// Se define que cuando el usuario se loggee lo lleve directamente al CRUD

/* Se define el grupo al que pertenece la autenticación

    Cuando el usuario se loggee utilice la autenticación ('auth')*/
Route::group(['middleware' => 'auth'], function () {
    // Aquí se define hacia donde debe dirigirse

    /* Se dirigira a EmpleadoController al método index() */
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
    
});
