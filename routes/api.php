<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => 'auth:api','prefix' => 'auth'], function ($router) {
//
// });


Route::get('crear/reservas' , 'api\ReservasController@crearReservas');
Route::get('listar/reservas', 'api\ReservasController@listarReservas');
// Route::get('reservas', 'api\ReservasController@obtenerReservas');

Route::get('login' , 'api\AuthController@login');
Route::post('registro' , 'api\AuthController@register');

Route::get('maquinas', 'api\MaquinasController@crearMaquinas');
Route::get('plazas', 'api\BloqueReservasPlazaController@crear');
Route::get('reservas/obtener', 'api\BloqueReservasPlazaController@obtener');
Route::post('app/carrito' , 'api\CarritoCompraController@insertCarritoCompra');

Route::get('lector/qr/token', 'api\ReservasController@leerCodigoQr');


/*Route::post('user' , 'api\AuthController@getAuthUser');*/

// estas rutas requiren de un token válido para poder accederse.
// Route::group(['middleware' => 'auth.jwt'], function () {
// Route::post('/logout', 'api\AuthController@logout');
// });
