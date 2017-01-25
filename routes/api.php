<?php

use Illuminate\Http\Request;

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


Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/carga/inicial', 'AdminController@initLoad');


    //Crear dimensiones
    Route::post('/crear/dimension', 'AdminController@createDimension');
    Route::post('/crear/requisito', 'AdminController@createRequisito');
    Route::post('/crear/pregunta', 'AdminController@createPregunta');
    //Traer Preguntas
    Route::get('/obtener/preguntas/{id}', 'AdminController@getPreguntas');


    //Usuarios

    Route::get('/obtener/usuarios', 'AdminController@getUsuarios');
    Route::get('/obtener/roles', 'AdminController@getRoles');


    //Crear usuario

    Route::post('/crear/usuario', 'AdminController@createUser');
    Route::post('/editar/usuario', 'AdminController@editUser');
    Route::post('/borrar/usuario', 'AdminController@deleteUser');
    Route::post('/crear/directorios', 'CuestionarioController@makeDirectory');
    Route::post('/recibir/archivos', 'CuestionarioController@files');


    //SuperVisor

    Route::get('/traer/revisores', 'SupervisorController@getRevisores');
    Route::get('/traer/oficinas/pendientes', 'SupervisorController@getOficinasPendientes');
    Route::post('/crear/asignacion', 'SupervisorController@createAsignacion');
    Route::get('traer/asignaciones', 'SupervisorController@getAsignaciones');

    //Revisor

    Route::get('/traer/revisor/asignaciones', 'RevisorController@getRevisorAsignaciones');


});
