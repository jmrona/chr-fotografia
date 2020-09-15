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

use App\Http\Controllers\AboutMeController;
use App\Http\Controllers\SocialMediaController;

// Home
Route::get('/', function () {
    return view('welcome');
});

// About me
Route::get('/about','AboutMeController@index');
Route::put('/about','AboutMeController@update');

// Social media
Route::get('/socialmedia', 'SocialMediaController@index');
Route::put('/socialmedia', 'SocialMediaController@update');

//Portfolio
Route::get('/portfolio','PortfolioController@index');
Route::post('/portfolio','PortfolioController@store');
Route::put('/portfolio/{id}','PortfolioController@update');
Route::delete('/portfolio/{id}','PortfolioController@destroy');

//Gallery
Route::get('/gallery/{id}','GalleryController@index');
Route::post('/gallery','GalleryController@store');
Route::put('/gallery','GalleryController@update');
Route::delete('/gallery/{img_id}/{portfolio_id}','GalleryController@destroy');

//Contact me
Route::get('/contact', function () {
    return view('welcome');
});


//Authentication
Auth::routes();

Route::prefix('auth')->group( function () {
    Route::get('init', 'AppController@init');

    Route::post('login', 'AppController@login');
    Route::post('register', 'Appcontroller@register');
    Route::post('logout', 'Appcontroller@logout');
});
