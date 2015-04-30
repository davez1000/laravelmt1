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

// Route::controllers([
// 	'auth' => 'Auth\AuthController',
// 	'password' => 'Auth\PasswordController',
// ]);
//
// Route::get('/', function() {
//   return redirect('metar/egll');
// });
Route::get('/', 'DboController@index');
Route::get('/metar/{icao}', 'DboController@metar');
Route::get('/metarsearch', 'DboController@metarsearch');

// Not allowed methods.
Route::get('/twatter/{param}', function() {
  return redirect('/');
})->where(['param' => 'api|api/data|api/data/store']);

Route::post('/twatter/api/data/store', 'TwatterController@store');
Route::get('/twatter/api/{type?}', 'TwatterController@create');


