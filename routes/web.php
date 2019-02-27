<?php

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
use App\Team;

// zakomentowano 19.12.2019

/*Route::get('/', function () {
    return view('pages.cup');
});*/

//dodano 19.12.2019
Route::resource('/', 'PagesController');

Route::get('/add_team/{id}', [
    'uses' => 'AddTeamController@update',
    'as' => 'add_team.update'
]);

// połaczenie z naszym kontrolerem
// pages- nazwa kontrolera
Route::resource('pages', 'PagesController');

Route::post('pages', [
    'uses' => 'PagesController@index',
    'as' => 'add_team.indexpages'
]);

Route::resource('test', 'TerminarzController');

Route::resource('new_game', 'NewGameController'); 

Route::post('new_game','NewGameController@store');

Route::resource('add_team', 'AddTeamController');

Route::post('add_team', [
    'uses' => 'AddTeamController@index',
    'as' => 'add_team.index'
]);

Route::get('add_team/delete/{id}', 'AddTeamController@destroy');


Route::post('add_team/store', [
    'uses' => 'AddTeamController@store',
    'as' => 'add_team.store'
]);

Route::get('/add_team/{id}', [
    'uses' => 'AddTeamController@update',
    'as' => 'add_team.update'
]);

Route::get('game/{id}', [
    'uses' => 'PagesController@show',
    'as' => 'pages.show'
]);
Route::get('game/{id}', [
    'uses' => 'GameController@manage',
    'as' => 'manage'
]);

// tu były zmiany - dodano n/ - 19-12-2018
Route::get('n/{id}', [ 
    'uses' => 'PagesController@show_game',
    'as' => 'pages.show_game'
]);


Route::put('game/{id}', [
    'uses' => 'GameController@store',
    'as' => 'game.store'
]);


Route::get('game/{id}/result', [
    'uses' => 'GameController@show',
    'as' => 'game.show_result'
]);

Route::get('game/{id}/group/{c}', [
    'uses' => 'GameController@cup_edit_result',
    'as' => 'game.cup_edit_result'
]);

Route::get('game/{id}/show_group/{c}', [
    'uses' => 'PagesController@show_cup_result',
    'as' => 'pages.show_cup_result'
]);

Route::get('game/{id}/edit', [
    'uses' => 'GameController@edit',
    'as' => 'game.edit'
]);

Route::put('game/{id}/update', [
    'uses' => 'GameController@update',
    'as' => 'game.update'
]);

Route::get('game/{id}/table', [
    'uses' => 'GameController@show_table',
    'as' => 'game.show_table'
]);

Route::get('game/delete/{id}', [
    'uses' => 'GameController@destroy',
    'as' => 'game.destroy'
]);


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', [
    'uses' => 'HomeController@register',
    'as' => 'register'
]);

Route::get('/', [
    'uses' => 'HomeController@index',
    'as' => 'login'
]);

?>