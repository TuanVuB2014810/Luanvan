<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
// use App\Http\Controllers\PostsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/admin-index', 'AdminController@dashboard') ;
Route::post('/chatbot/send-message', [ChatbotController::class, 'sendMessage']);
// Route::get('/generate-posts', [PostsController::class, 'generateFakePosts']);
// Route::post('/store-posts', [PostsController::class, 'storeFakePosts']);
