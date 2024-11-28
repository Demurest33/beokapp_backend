<?php

namespace App\Http\Controllers;

use App\Models\myUser;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'user_id' => 'required|exists:my_users,id',
            'products' => 'required|array',
            'pick_up_date' => 'required|string',
            'payment_type' => 'required|string',
            'total' => 'required|numeric',
            'additionalInstructions' => 'nullable|string',
        ]);

        // Iniciar una transacción para asegurar que los datos sean consistentes
        DB::beginTransaction();

        try {
            // Crear el pedido
            $order = Order::create([
                'user_id' => $request->user_id,
                'pick_up_date' => $request->pick_up_date,
                'payment_type' => $request->payment_type,
                'total' => $request->total,
                'message' => $request->additionalInstructions,
                'hash' => 'temp'
            ]);

            // Generar el hash basado en el ID del pedido y actualizarlo
            $order->hash = hash('sha256', $order->id);
            $order->save();

            // Guardar los productos del pedido
            foreach ($request->products as $productData) {
                // Encontrar el producto por su ID
                $product = Product::findOrFail($productData['id']);

                // Crear la relación con la tabla intermedia (OrderProduct)
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'price' => $productData['totalPrice'],
                    'selected_options' => json_encode($productData['selectedOptions']),
                    'image_url' => $productData['image_url'],
                    'product_name' => $productData['name']

                ]);
            }

            // Confirmar la transacción
            DB::commit();

            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order,
            ], 201);

        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            DB::rollBack();

            return response()->json([
                'error' => 'An error occurred while processing the order',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function index(Request $request)
    {
        $userId = $request->input('user_id'); // Obtener el ID del usuario del request

        // Buscar el rol del usuario desde la base de datos
        $user = myUser::find($userId);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        if ($user->role === 'ADMIN' || $user->role === 'AUXILIAR') {
            // Si el usuario es admin, devuelve todas las órdenes
            $orders = Order::all();
        } else {
            // Si el usuario es cliente, solo devuelve sus propias órdenes
            $orders = Order::where('user_id', $userId)->get();
        }

        return response()->json($orders);
    }


    public function toggleFavorite($id)
    {
        try {
            // Buscar la orden por su ID
            $order = Order::findOrFail($id);

            // Cambiar el estado de "is_fav" (true a false o viceversa)
            $order->is_fav = !$order->is_fav;
            $order->save();

            return response()->json([
                'message' => 'Order favorite status updated successfully.',
                'order' => $order
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update favorite status.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'pick_up_date' => 'required|string',
        ]);

        $originalOrder = Order::with('products')->find($request->order_id);


        // Crear el nuevo pedido
        $newOrder = Order::create([
            'user_id' => $originalOrder->user_id,
            'total' => $originalOrder->total,
            'status' => 'Preparando', // Estado inicial del pedido
            'pick_up_date' => $request->pick_up_date,
            'message' => $originalOrder->message,
        ]);

        // Copiar los productos del pedido original al nuevo pedido
        foreach ($originalOrder->products as $product) {
            OrderProduct::create([
                'order_id' => $newOrder->id,
                'product_id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'price' => $product->pivot->price,
                'selected_options' => json_decode($product->pivot->selected_options, true),
                'image_url' => $product->pivot->image_url,
                'product_name' => $product->name,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pedido creado exitosamente.',
            'new_order_id' => $newOrder->id,
        ]);
    }

}
