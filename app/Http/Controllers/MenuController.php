<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getMenu(): \Illuminate\Http\JsonResponse
    {
        $menu = Category::with('products')->get();

        return response()->json($menu);
    }
}
