<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\BlogApiController;
use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\CommentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Auth Route
Route::post('/register',[AuthApiController::class,'register'])->name('api.register');
Route::post('/login',[AuthApiController::class,'login'])->name('api.login');
//Blog Route
Route::get('/home',[BlogApiController::class,'home']);
Route::get('/blogs',[BlogApiController::class,'index']);
Route::get('/blogs/{id}',[BlogApiController::class,'show']);
//Comment Route
Route::get('/comments',[CommentApiController::class,'index']);
Route::get('/comments/{id}',[CommentApiController::class,'show']);
//Category Route
Route::get('/categories',[CategoryApiController::class,'index']);

Route::middleware('auth:sanctum')->group(function(){
    //Auth Route
    Route::post('/logout',[AuthApiController::class,'logout'])->name('api.logout');
    Route::post('/update',[AuthApiController::class,'update']);

    //Blog Route
    Route::post('/blogs',[BlogApiController::class,'store']);
    Route::put('/blogs/{id}',[BlogApiController::class,'update']);
    Route::delete('/blogs/{id}',[BlogApiController::class,'destroy']);
    //Comment Route
    Route::post('/comments',[CommentApiController::class,'store']);
    Route::put('/comments/{id}',[CommentApiController::class,'update']);
    Route::delete('/comments/{id}',[CommentApiController::class,'destroy']);

    // Category Route
});


