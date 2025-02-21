<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;

Route::controller(RegisterController::class)->group(function(): void{
    // Param 1 - route name, Param 2 - controller method
    Route::post('register','register');
    Route::post('login','login');
    Route::post('logout','logout');
});