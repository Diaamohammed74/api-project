<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('auth')->controller(AuthController::class)
    ->group(function () {
            Route::post('register', 'register');
            Route::post('login', 'login');
            Route::post('logout', 'logout');
            Route::post('refresh', 'refresh');
            Route::post('me', 'me');
            Route::post('resend/verifycode', 'resnedVerificationCode');
            Route::post('account-Verify', 'emailActivation');
});