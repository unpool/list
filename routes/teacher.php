<?php
Route::get('dashboard', function () {
    return view('teacher.dashboard');
})->name('dashboard');

Route::group([
    'prefix' => 'profile',
    'as' => 'profile.'
], function () {
    Route::get('', [
        'as' => 'index',
        'uses' => 'ProfileController@index'
    ]);
    Route::get('edit', [
        'as' => 'edit',
        'uses' => 'ProfileController@edit'
    ]);
    Route::post('update', [
        'as' => 'update',
        'uses' => 'ProfileController@update'
    ]);
    Route::post('tiny-mce-image-upload', [
        'as' => 'tiny-mce-image-upload',
        'uses' => 'ProfileController@tinyMceImageUpload'
    ]);
});
