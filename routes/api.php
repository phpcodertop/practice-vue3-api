<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogPostsController;
use App\Http\Controllers\Api\ContactsController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\TodosController;
use App\Http\Controllers\Api\UserManagerController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// todo faq
// todo calender, events
// todo gallery
// todo chat
// todo invoices
// todo ecommerce
// todo blog
// todo charts
// todo support
// todo prayer times

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('profile', [AuthController::class, 'profile']);
});

Route::apiResource('blog', BlogPostsController::class);

Route::post('contact-us', ContactUsController::class);

Route::group([
    'middleware' => 'jwt'
], function ($router) {

    Route::apiResource('todos', TodosController::class);

    Route::apiResource('contacts', ContactsController::class);

    Route::apiResource('users', UserManagerController::class);


});


