<?php
namespace App\Http\Controllers;

use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderProductController extends Controller
{
    public function getOrderProductDetails(Order $order)
    {
        // Obtener todos los productos de la orden
        $orderProducts = OrderProduct::where('order_id', $order->id)
            ->get()
            ->map(function ($orderProduct) {
                // Decodificar las opciones seleccionadas desde JSON a un array
                $orderProduct->selected_options = json_decode($orderProduct->selected_options, true);
                return $orderProduct;
            });

        // Crear un array con solo las opciones seleccionadas
        $selectedOptions = $orderProducts->pluck('selected_options');  // Obtiene solo las opciones de todos los productos

        // Devolver la respuesta con los productos y las opciones seleccionadas separadas
        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'order_products' => $orderProducts,  // Productos con opciones decodificadas
            'selected_options' => $selectedOptions,  // Opciones seleccionadas como array
        ]);

    }
}
