<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;

Route::controller(RegisterController::class)->group(function(): void{
    // Param 1 - route name, Param 2 - controller method
    Route::post('register','register');
    Route::post('login','login');
    Route::post('logout','logout');
    Route::post('forgot_password','forgotPassword');
    Route::get('password_reset','passwordReset');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::controller(UserController::class)->group(function(){
    Route::get('user', 'getUser');
    Route::post('user/upload_avatar', 'uploadAvatar');
    Route::delete('user/remove_avatar','removeAvatar');
    Route::post('user/send_verification_email','sendVerificationEmail');
    Route::post('user/change_email', 'changeEmail');
    });
});