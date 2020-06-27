<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Route::get('/', 'PagesController@getIndex')->name('index');

// use Illuminate\Support\Facades\URL;

// $url =  URL::temporarySignedRoute(
//     'ajax-helper', now()->addMinutes(30));
//     echo route('register') . '?ref=ola';


Route::get('/mail', 'PaystackController@mail');
Route::post('/ajax-helper', 'PagesController@postHelper')->name('ajax-helper');
Route::get('/payment', 'PaystackController@pay')->name('payment');
Route::get('/callback', 'PaystackController@callback')->name('callback');
Route::get('/settings/', function () {
    // Users must confirm their password before continuing...
    echo "Success";
})->middleware(['auth', 'password.confirm']);
Route::get('/unsubscribe', function (Request $request) {
    if (! $request->hasValidSignature()) {
        abort(401);
    }
    echo "Success";

    // ...
})->name('unsubscribe');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
