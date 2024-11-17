<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getMenu()
    {
        $categories = Category::with('products')->get();

        return response()->json([
            'categories' => $categories
        ]);
    }

}
