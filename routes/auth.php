<?php
// Auth For Admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::get('login', [
        'as' => 'loginForm',
        'uses' => 'LoginController@loginForm'
    ]);

    Route::post('login', [
        'as' => 'login',
        'uses' => 'LoginController@login'
    ]);

    Route::post('logout', [
        'as' => 'logout',
        'uses' => 'LoginController@logout'
    ]);
});

// Auth For Teacher
Route::group(['prefix' => 'teacher', 'namespace' => 'Teacher', 'as' => 'teacher.'], function () {
    Route::get('login', [
        'as' => 'loginForm',
        'uses' => 'LoginController@loginForm'
    ]);

    Route::post('login', [
        'as' => 'login',
        'uses' => 'LoginController@login'
    ]);

    Route::post('logout', [
        'as' => 'logout',
        'uses' => 'LoginController@logout'
    ]);
});