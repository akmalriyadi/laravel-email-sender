<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AuthControllerApi;
use App\Http\Controllers\Api\SettingControllerApi;
use App\Http\Controllers\Api\DocumentControllerApi;
use App\Http\Controllers\Api\TemplateControllerApi;
use App\Http\Controllers\Api\EmailSenderControllerApi;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/auth/login', [AuthControllerApi::class, 'authenticate']);
Route::post('/auth/login', [AuthControllerApi::class, 'logout']);

Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::group([
        'prefix' => 'templates',
        'controller' => TemplateControllerApi::class
    ], function () {
        Route::get('/', 'index');
        Route::get('/trashed', 'trashed');
        Route::get('/show/{id}', 'show');
        Route::post('/', 'store');
        Route::post('/update/{id}', 'update');
        Route::post('/delete/{id}', 'delete');
        Route::post('/restore/{id}', 'restore');
        Route::post('/force-delete/{id}', 'forceDelete');
    });

    Route::group([
        'prefix' => 'documents',
        'controller' => DocumentControllerApi::class
    ], function () {
        Route::get('/', 'index');
        Route::get('/trashed', 'trashed');
        Route::get('/show/{id}', 'show');
        Route::post('/', 'store');
        Route::post('/update/{id}', 'update');
        Route::post('/delete/{id}', 'delete');
        Route::post('/restore/{id}', 'restore');
        Route::post('/force-delete/{id}', 'forceDelete');
    });

    Route::group([
        'prefix' => 'email-senders',
        'controller' => EmailSenderControllerApi::class
    ], function () {
        Route::get('/', 'index');
        Route::get('/trashed', 'trashed');
        Route::get('/show/{id}', 'show');
        Route::post('/', 'store');
        Route::post('/update/{id}', 'update');
        Route::post('/send/{id}', 'send');
        Route::post('/delete/{id}', 'delete');
        Route::post('/restore/{id}', 'restore');
        Route::post('/force-delete/{id}', 'forceDelete');
    });
    Route::group([
        'prefix' => 'setting',
        'controller' => SettingControllerApi::class
    ], function () {
        Route::get('/show/{id}', 'show');
        Route::post('/update/{id}', 'update');
        Route::post('/delete/{id}', 'delete');
    });

});