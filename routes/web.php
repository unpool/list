<?php

use Illuminate\Http\Request;
use App\Models\Order;

Route::get('/', function () {
    return view('home');
})->name('home-page');


Route::get('check-payment',  [
    'as' => 'check-payment',
    'uses' => 'Controller@checkPayment',
]);

Route::get('check-wallet',  [
    'as' => 'check-wallet',
    'uses' => 'Controller@checkWallet',
]);

Route::get('mota', 'Mota')->name('mota-test');
