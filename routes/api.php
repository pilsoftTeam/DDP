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
    Route::get('/carga/rechazada/inicial/{id}', 'AdminController@rejectedLoad');


    //Crear dimensiones
    Route::post('/crear/dimension', 'AdminController@createDimension');
    Route::post('/crear/requisito', 'AdminController@createRequisito');
    Route::post('/crear/pregunta', 'AdminController@createPregunta');


    //Edicion Dimensiones

    Route::post('/editar/requisito', 'AdminController@editarRequisito');
    Route::delete('/eliminar/requisito/{id}', 'AdminController@eliminarRequisito');


    //Traer Preguntas
    Route::get('/obtener/preguntas/{id}', 'AdminController@getPreguntas');
    Route::get('/obtener/preguntas/by/{id}', 'AdminController@getPreguntasById');
    Route::get('/obtener/requisito/{id}', 'AdminController@getRequisito');


    //Edicion Preguntas
    Route::post('/editar/pregunta', 'AdminController@editPregunta');
    Route::post('/eliminar/pregunta/{id}', 'AdminController@deletePregunta');


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
    Route::get('/traer/oficinas', 'SupervisorController@getOficinas');
    Route::post('/crear/asignacion', 'SupervisorController@createAsignacion');
    Route::get('/traer/asignaciones', 'SupervisorController@getAsignaciones');


    Route::post('/traer/docs', 'SupervisorController@getDocs');


    Route::get('/asignaciones/revisadas', 'SupervisorController@getAsignacionesRevisadas');

    Route::post('/terminar/revision', 'SupervisorController@end');

    //Revisor

    Route::get('/traer/revisor/asignaciones', 'RevisorController@getRevisorAsignaciones');
    Route::post('/terminar/checklist', 'RevisorController@terminar');


});
