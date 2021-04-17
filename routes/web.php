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

Auth::routes();

Route::get('/', function () {
    return view('index');
});

Route::group(["prefix" => "admin", 'middleware' => "auth"], function () {
    Route::get('/', function () {
        return view('admin/index');
    });
    Route::resource('sections', 'SectionController');
    Route::resource('products', 'ProductController');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

Route::get('/{page}', 'AdminController@index');
