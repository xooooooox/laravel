<?php

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

// /api/
Route::any('/',function (){echo 'api';});

// /api/v1
Route::prefix('v1')->namespace('V1')->middleware(['v1'])->group(function () {
    // /api/v1/
    Route::any('/',function (){echo 'v1';});

    // /api/v1/user
    Route::prefix('user')->namespace('User')->middleware([])->group(function () {
        // /api/v1/user/
        Route::any('/',function (){echo 'user';});

        // /api/v1/user/outside
        Route::prefix('outside')->namespace('Outside')->middleware([])->group(function () {
            // /api/v1/user/outside/register
            Route::post('register','IndexController@register')->middleware([])->name('register');
            // /api/v1/user/outside/login
            Route::any('login','IndexController@login')->middleware(['v1login'])->name('login');
            // /api/v1/user/outside/abc
            Route::match(['get','post'],'abc',function () {echo 'abc';})->middleware([])->name('abc');
            // /api/v1/user/outside/x
            Route::post('/x','XyzController@x')->middleware(['a','b','c'])->name('x');

            Route::post('/users','Database@users');
        });

    });

});
