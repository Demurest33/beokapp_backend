<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getOptions($id)
    {
        // Buscar el producto por ID
        $product = Product::with('options')->find($id);

        // Verificar si el producto existe
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        // Devolver las opciones del producto
        return response()->json([
            "options" => $product->options
        ]);
    }

    public function getProductById($id)
    {
        // Buscar el producto junto con sus opciones
        $product = Product::with('options')->find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }
}
