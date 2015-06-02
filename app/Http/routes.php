<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('autenticar/{login}/{password}', 'HomeController@autenticar');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('informes',"InformesController@index");
Route::get('informes/{id}',"InformesController@getInforme");

Route::post('login',"LoginController@login");

Route::get('capmod',"ModulosCapController@index");
Route::get('capmod/{id}',"ModulosCapController@modulos");
Route::post('capmod/{id}',"ModulosCapController@asignarMod");
Route::put('capmod/{id}',"ModulosCapController@updateMod");
Route::delete('capmod/del/{id}/{idCap}',"ModulosCapController@delMod");

Route::get('capacidades',"CapacidadesController@index");
Route::get('capacidades/{id}',"CapacidadesController@modulos");
Route::post('capacidades/{id}',"CapacidadesController@asignarApp");
Route::put('capacidades/{id}',"CapacidadesController@updateApp");
Route::post('capacidades/mod/{id}',"CapacidadesController@asignarMod");
Route::delete('capacidades/del/{id}/{idCap}',"CapacidadesController@delApp");

Route::get('aplicaciones',"AplicacionController@index");
Route::get('aplicaciones/{id}',"AplicacionController@show");
Route::post('aplicaciones',"AplicacionController@store");
Route::put('aplicaciones/{id}',"AplicacionController@update");
Route::delete('aplicaciones/{id}',"AplicacionController@destroy");

Route::get('ingenieros',"IngenierosController@index");
Route::get('ingenieros/{id}',"IngenierosController@show");
Route::get('ingenieros/{id}/{idApp}',"IngenierosController@showMod");
Route::post('ingenieros',"IngenierosController@store");
Route::post('ingenieros/{id}/{idApp}',"IngenierosController@storeMod");
Route::post('ingenieros/remove/{id}/{idApp}',"IngenierosController@removeMod");
Route::put('ingenieros/{id}',"IngenierosController@update");
Route::delete('ingenieros/{id}',"IngenierosController@destroy");

Route::get('funcionales',"FuncionalesController@index");
Route::get('funcionales/{id}',"FuncionalesController@show");
Route::get('funcionales/{id}/{idApp}',"FuncionalesController@showMod");
Route::post('funcionales',"FuncionalesController@store");
Route::post('funcionales/{id}/{idApp}',"FuncionalesController@storeMod");
Route::post('funcionales/remove/{id}/{idApp}',"FuncionalesController@removeMod");
Route::put('funcionales/{id}',"FuncionalesController@update");
Route::delete('funcionales/{id}',"FuncionalesController@destroy");

Route::get('modulos/',"ModulosController@index");
Route::get('modulos/{id}',"ModulosController@indexApp");
Route::get('modulos/{id}/{idApp}',"ModulosController@show");
Route::post('modulos',"ModulosController@store");
Route::put('modulos/{id}',"ModulosController@update");
Route::delete('modulos/{id}',"ModulosController@destroy");

Route::get('configuraciones',"ConfiguracionController@index");
Route::get('configuraciones/{id}',"ConfiguracionController@show");
Route::get('configuraciones/{id}/{idApp}',"ConfiguracionController@showConfig");
Route::post('configuraciones',"ConfiguracionController@store");
Route::put('configuraciones/{id}',"ConfiguracionController@update");
Route::delete('configuraciones/{id}',"ConfiguracionController@destroy");