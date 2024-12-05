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
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderProduct;

//Test
Route::get('/', function () {
    return ['message' => 'hola mundo'];
});

//Auth
Route::post('/login', [LoginController::class, 'login']); // Ruta para el login
Route::post('/register', [RegisterController::class, 'register']);

//Users
Route::get('/users', [myUsersController::class, 'index']);
Route::put('/users/{id}/role', [myUsersController::class, 'updateRole']);

//Sms
Route::post('/send-sms', [sendSmsVerification::class, 'sendsms']);
Route::post('/send-whatsApp', [sendSmsVerification::class, 'sendWhatsApp']);
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
Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus']);
Route::patch('/orders/{order}/toggle-paid', [OrderController::class, 'togglePaid']);

//QR
Route::post('/decode-qr', function (Request $request) {
    $hash = $request->input('hash');
    $pedido = Order::where('hash', $hash)->first();

    if ($pedido) {
        // Obtener todos los productos de la orden utilizando el modelo OrderProduct
        $orderProducts = OrderProduct::where('order_id', $pedido->id)
            ->get()
            ->map(function ($orderProduct) {
                // Decodificar las opciones seleccionadas desde JSON a un array
                $orderProduct->selected_options = json_decode($orderProduct->selected_options, true);
                return $orderProduct;
            });

        // Devolver los datos
        return response()->json([
            'order' => $pedido,
            'order_products' => $orderProducts,
        ]);
    }

    return response()->json(['error' => 'Pedido no encontrado'], 404);
});


