<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\TemplateController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::redirect('/', '/login')->middleware('customGuest');

Route::get('/login', function () {
    return Inertia::render('Login');
})->middleware('customGuest')->name('login');

Route::post('/auth/login', [AuthController::class, 'authenticate']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::group([
    'prefix' => 'admin',
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    });

    Route::group([
        'prefix' => 'templates',
        'controller' => TemplateController::class
    ], function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{id}', 'edit')->name('edit_template');
    });
    Route::group([
        'prefix' => 'documents',
        'controller' => DocumentController::class
    ], function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{id}', 'edit')->name('edit_document');
    });
    Route::group([
        'prefix' => 'email-senders'
    ], function () {
        Route::get('/', function () {
            return Inertia::render('Admin/Email/Index');
        });
        Route::get('/create', function () {
            return Inertia::render('Admin/Email/Form');
        });
    });
    Route::group([
        'prefix' => 'setting'
    ], function () {
        Route::get('/', function () {
            return Inertia::render('Admin/Setting');
        });
    });
});

Route::get('test-email/{id}', [EmailController::class, 'test']);
Route::get('test-email/', [EmailController::class, 'test']);
