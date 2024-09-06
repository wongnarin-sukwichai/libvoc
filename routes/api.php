<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DepController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\ConcernController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\StatController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('dep', DepController::class);
Route::resource('type', TypeController::class);
Route::resource('concern', ConcernController::class);
Route::resource('post', PostController::class);
Route::resource('stat', StatController::class);
Route::resource('comment', CommentController::class);

Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', UserController::class);
    Route::post('forward', [CommentController::class, 'forward']);
    Route::post('complete', [CommentController::class, 'complete']);
    Route::get('upPost/{id}/{code}', [AdminController::class, 'upPost']);
    Route::resource('admin', AdminController::class);
    Route::resource('staff', StaffController::class);

    Route::get('getPost', [ApiController::class, 'getPost']);
    Route::get('getConcern', [ApiController::class, 'getConcern']);
    Route::get('getType', [ApiController::class, 'getType']);
});


