<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\CategoryController;

Route::middleware(['api', 'auth'])->prefix('/categories')
    ->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index');
        Route::POST('/store', 'store');
        Route::get('/show', 'show');
    });