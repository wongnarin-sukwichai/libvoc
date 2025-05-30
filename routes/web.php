<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('symlink', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'OK';
});

Route::get('fail', function () {
    abort(401);
})->name('fail');

Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');

