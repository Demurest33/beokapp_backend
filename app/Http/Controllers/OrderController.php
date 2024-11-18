<?php

namespace App\Http\Controllers;

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
                'additional_instructions' => $request->additionalInstructions,
            ]);

            // Guardar los productos del pedido
            foreach ($request->products as $productData) {
                // Encontrar el producto por su ID
                $product = Product::findOrFail($productData['id']);

                // Crear la relación con la tabla intermedia (OrderProduct)
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'price' => $productData['price'],
                    'selected_options' => json_encode($productData['selectedOptions']), // Guardamos las opciones seleccionadas como JSON
                    'image_url' => $productData['image_url'],
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

        // Verificamos si el usuario es admin o cliente
        if ($request->input('role') === 'ADMIN') {
            // Si el usuario es admin, devuelve todas las órdenes
            $orders = Order::all();
        } else {
            // Si el usuario es cliente, solo devuelve sus propias órdenes
            $orders = Order::where('user_id', $userId)->get();
        }

        return response()->json($orders);
    }
}
