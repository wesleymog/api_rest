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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('tags')->group(function (){
	Route::get('/', 'TagController@index')->name('tags');
	Route::get('/{id}', 'TagController@show')->name('single_tag');
	Route::post('/', 'TagController@store')->name('add_tag');
	Route::put('/{id}', 'TagController@update')->name('update_tag');
	Route::delete('/{id}', 'TagController@delete')->name('delete_tag');
});
Route::prefix('users')->group(function (){
	Route::get('/', 'UserController@index')->name('users');
	Route::get('/{id}', 'UserController@show')->name('single_user');
	Route::post('/', 'UserController@store')->name('add_user');
	Route::put('/{id}', 'UserController@update')->name('update_user');
	Route::delete('/{id}', 'UserController@delete')->name('delete_user');
});

Route::prefix('events')->group(function (){
	Route::get('/', 'EventController@index')->name('events');
	Route::get('/{id}', 'EventController@show')->name('single_event');
	Route::post('/', 'EventController@store')->name('add_event');
	Route::put('/{id}', 'EventController@update')->name('update_event');
	Route::delete('/{id}', 'EventController@delete')->name('delete_event');
});
Route::get('home/{id}', 'UserController@home'); //retorna a home com os eventos à ver com as tags


Route::prefix('participation')->group(function (){
	Route::post('/', 'ParticipationController@confirmation')->name('confirmation_participation');
	Route::post('/rate', 'ParticipationController@rating')->name('rate_participation'); // 'rate', 'event_id' or 'status', 'event_id'
});

Route::prefix('transaction')->group(function (){
	Route::post('/', 'TransactionController@store')->name('add_transaction');
	Route::get('/{id}', 'TransactionController@getAllMyTransactions')->name('get_users_transactions');
});
