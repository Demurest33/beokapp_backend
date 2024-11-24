<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\ProductController;
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

//Menu
Route::get('/menu', [MenuController::class, 'getMenu']);

//Products
Route::get('product/{id}/options', [ProductController::class, 'getOptions']);
Route::get('/product/{id}', [ProductController::class, 'getProductById']);

//Pedidos
Route::post('/orders', [OrderController::class, 'store']);
Route::post('/get-orders', [OrderController::class, 'index']);
Route::get('/orders/{order}/order-products', [OrderProductController::class, 'getOrderProductDetails']);
Route::patch('/orders/{id}/favorite', [OrderController::class, 'toggleFavorite']);
Route::post('/orders/reorder', [OrderController::class, 'reorder']);
