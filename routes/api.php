<?php


Route::group([
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('payload','AuthController@payload');
    Route::get('userlist','AuthController@userList');
});
Route::group([
    'prefix' => 'guest'

], function () {

    Route::post('login', 'GuestsController@login');
    Route::post('logout', 'GuestsController@logout');
    Route::post('refresh', 'GuestsController@refresh');
    Route::post('me', 'GuestsController@me');
    Route::post('payload','GuestsController@payload');
    
});
Route::get('/','GetsController@index');