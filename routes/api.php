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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('register', 'AuthController@register');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});


Route::group([
    'middleware' => 'auth:api'
  ], function() {
    Route::prefix('tags')->group(function (){
        Route::get('/', 'TagController@index')->name('tags');
        Route::get('/{id}', 'TagController@show')->name('single_tag');
        Route::post('/', 'TagController@store')->name('add_tag');
        Route::put('/{id}', 'TagController@update')->name('update_tag');
        Route::delete('/{id}', 'TagController@delete')->name('delete_tag');
        Route::post('/autocomplete', 'TagController@autocomplete')->name('autocomplete_tag');
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
        Route::put('/one/{id}', 'EventController@updateone')->name('update_event');
        Route::delete('/{id}', 'EventController@delete')->name('delete_event');
        Route::delete('/one/{id}', 'EventController@deleteone')->name('delete_one_event');
        Route::post('/autocomplete', 'EventController@autocomplete')->name('autocomplete_event');
    });

    Route::get('home', 'HomeController@home'); //retorna a home com os eventos à ver com as tags
    Route::get('experiences', 'HomeController@experiences'); //retorna a home com os eventos à ver com as tags

    Route::prefix('participation')->group(function (){
        Route::post('/', 'ParticipationController@confirmation')->name('participation');
        Route::post('/confirm', 'ParticipationController@confirmation')->name('confirmation_participation');
        Route::post('/interest', 'ParticipationController@interest')->name('interest_participation');
        Route::post('/rate', 'ParticipationController@rating')->name('rate_participation'); // 'rate', 'event_id' or 'status', 'event_id'
        Route::get('/all', function () {
            return response()->json(App\Participation::all(),200);
        });
    });

    Route::prefix('transaction')->group(function (){
        Route::post('/', 'TransactionController@store')->name('add_transaction');
        Route::get('/', 'TransactionController@getAllMyTransactions')->name('get_users_transactions');
    });

    Route::get('/mytransactions', 'TransactionController@getAllMyTransactions')->name('get_users_transactions');

    Route::prefix('rewards')->group(function (){
        Route::get('/', 'RewardController@index')->name('rewards');
        Route::get('/{id}', 'RewardController@show')->name('single_reward');
        Route::post('/', 'RewardController@store')->name('add_reward');
        Route::put('/{id}', 'RewardController@update')->name('update_reward');
        Route::delete('/{id}', 'RewardController@delete')->name('delete_reward');
    });

    Route::prefix('community')->group(function (){
        Route::get('/', 'CommunityController@index')->name('comunnity');
    });


    Route::prefix('journey')->group(function (){
        Route::get('/', 'UserController@journey')->name('journey');
    });


    Route::prefix('myinitiatives')->group(function (){
        Route::get('/', 'UserController@myinitiatives')->name('myinitiatives');
    });
    Route::post('/getreward', 'TransactionController@getReward')->name('get_Reward');
    Route::get('/myreward', 'TransactionController@getMyReward')->name('get_my_Reward');


  });

  Route::group([
    'middleware' => 'admin'
  ], function() {
    Route::prefix('admin')->group(function (){
        Route::get('/', 'AdminController@index')->name('admin_index');
    });

    Route::prefix('rewards')->group(function (){
        Route::post('/', 'RewardController@store')->name('add_reward');
        Route::put('/{id}', 'RewardController@update')->name('update_reward');
        Route::delete('/{id}', 'RewardController@delete')->name('delete_reward');
    });

  });
