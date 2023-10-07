<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('guest.welcome');
});

Auth::routes();

Route::middleware('auth')
    // Folder where there are the controllers
    ->namespace('Admin')
    // Update the name with admin.
    ->name('admin.')
    // Update URL with admin/
    ->prefix('admin')
    // All the routes
    ->group(function() {
        Route::get('/home', 'HomeController@index')->name('home');
    });
