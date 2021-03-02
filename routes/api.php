<?php

use App\Http\Controllers\WidgetController;
use App\Http\Middleware\TokenAuthentication;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(TokenAuthentication::class)->resource('widgets', WidgetController::class)->only([
    'index',
    'store', // POST
    'show', // GET
    'update', // PUT/PATCH
    'destroy' // DELETE
]);
