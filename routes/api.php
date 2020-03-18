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
    Route::post('authenticate', 'AuthController@authenticate')->name('login');
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
        Route::post('/search', 'EventController@search')->name('search_event');

    });

    Route::prefix('notifications')->group(function (){
        Route::get('/', 'NotificationController@index')->name('notification');
        Route::get('/{id}', 'NotificationController@show')->name('single_notification');
        Route::post('/', 'NotificationController@store')->name('add_notification');
        Route::put('/{id}', 'NotificationController@update')->name('update_notification');
        Route::put('/markAsRead/{id}', 'NotificationController@markAsRead')->name('markAsRead_notification');
        Route::delete('/{id}', 'NotificationController@delete')->name('delete_notification');
    });

    Route::get('/mynotifications', 'HomeController@notifications');

    //Route::get('experiences', 'HomeController@experiences'); //retorna a home com os eventos à ver com as tags
    Route::prefix('home')->group(function (){
        Route::get('/', 'HomeController@home')->name('home');
        Route::get('/alta', 'HomeController@alta')->name('alta');
        Route::get('/proximas', 'HomeController@proximas')->name('proximas');
        Route::get('/held', 'HomeController@held')->name('held');
        Route::get('/going', 'HomeController@going')->name('going');
        Route::get('/byme', 'HomeController@byme')->name('going');

    });
    Route::prefix('participation')->group(function (){
        Route::post('/', 'ParticipationController@confirmation')->name('participation');
        Route::post('/confirm', 'ParticipationController@confirmation')->name('confirmation_participation');
        Route::post('/interest', 'ParticipationController@interest')->name('interest_participation');
        Route::post('/rate', 'ParticipationController@rating')->name('rate_participation'); // 'rate', 'event_id' or 'status', 'event_id'
        Route::get('/all', function () {
            return response()->json(App\Participation::all(),200);
        });
    });

    Route::prefix('content')->group(function (){
        Route::get('/', 'ContentController@index')->name('all_content');
        Route::get('/{id}', 'ContentController@show')->name('show_content');
        Route::post('/', 'ContentController@store')->name('add_content');
        Route::put('/{id}', 'ContentController@update')->name('update_content');
        Route::delete('/{id}', 'ContentController@delete')->name('delete_content');
    });

    Route::prefix('transaction')->group(function (){
        Route::post('/', 'TransactionController@store')->name('add_transaction');
        Route::get('/', 'TransactionController@getAllMyTransactions')->name('get_users_transactions');
    });

    Route::prefix('invitation')->group(function (){
        Route::post('/', 'InvitationController@store')->name('add_invitation');
        Route::get('/event/{id}', 'EventController@Invitation')->name('get_invitations_by_event');
    });

    Route::get('/myinvitations', 'UserController@myInvitations')->name('get_user_invitations');

    Route::get('/mytransactions', 'TransactionController@getAllMyTransactions')->name('get_users_transactions');

    Route::prefix('rewards')->group(function (){
        Route::get('/', 'RewardController@index')->name('rewards');
        Route::get('/{id}', 'RewardController@show')->name('single_reward');
        Route::post('/', 'RewardController@store')->name('add_reward');
        Route::put('/{id}', 'RewardController@update')->name('update_reward');
        Route::delete('/{id}', 'RewardController@delete')->name('delete_reward');
    });

    Route::prefix('communities')->group(function (){
        Route::get('/', 'CommunityController@index')->name('comunnities');
        Route::get('/mycommunities', 'CommunityController@myCommunities')->name('Mycomunnities');
        Route::get('/{id}', 'CommunityController@show')->name('single_comunnity');
        Route::post('/', 'CommunityController@store')->name('add_comunnity');
        Route::put('/{id}', 'CommunityController@update')->name('update_comunnity');
        Route::delete('/{id}', 'CommunityController@delete')->name('delete_comunnity');
        Route::post('/subscribeuser', 'CommunityController@subscribeUser')->name('subscribe_user_comunnity');
        Route::post('/subscribemyself', 'CommunityController@subscribeMyself')->name('subscribe_myself_comunnity');
        Route::post('/subscribeevent', 'CommunityController@subscribeEvent')->name('subscribe_event_comunnity');
        Route::post('/subscribecontent', 'CommunityController@subscribeContent')->name('subscribe_content_comunnity');

    });


    Route::prefix('journey')->group(function (){
        Route::get('/', 'UserController@journey')->name('journey');
    });

    Route::prefix('admin')->group(function (){
        Route::post('/dashboard', 'AdminController@dashboard')->name('admin_index');
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
    Route::get('export', 'UserControllerser@export')->name('export');
    Route::post('users/import', 'UserController@import')->name('import');
  });
