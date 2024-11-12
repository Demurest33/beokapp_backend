<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\myUsersController;
use App\Http\Controllers\sendSmsVerification;
use App\Http\Controllers\Auth\LoginController;

//Test
Route::get('/', function () {
    return ['message' => 'hola mundo'];
});

//Auth
Route::post('/login', [LoginController::class, 'login']); // Ruta para el login
Route::post('/register', [RegisterController::class, 'register']);

//Users
Route::get('/users', [myUsersController::class, 'index']);


//Sms
Route::post('/send-sms', [sendSmsVerification::class, 'sendsms']);
Route::post('/verify-code', [sendSmsVerification::class, 'checkVerification']);
//test-sms
Route::post('/dummy-send-sms', [sendSmsVerification::class, 'sendDummySms']);
Route::post('/dummy-verify-code', [sendSmsVerification::class, 'verifyDummySms']);
