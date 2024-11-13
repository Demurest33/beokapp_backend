<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {

        $desayunos = Category::where('name', 'Desayunos')->first();
        $bebidasSnacks = Category::where('name', 'Bebidas y Snacks')->first();
        $comidaCorrida = Category::where('name', 'Comida Corrida')->first();
        $comidaTodoDia = Category::where('name', 'Comida de Todo el Día')->first();

        Product::create([
            'name' => 'Huevos Rancheros',
            'description' => 'Huevos con salsa ranchera',
            'price' => 45.50,
            'category_id' => $desayunos->id,
            'image_url' => 'https://newmansown.com/wp-content/uploads/2024/07/huevos-rancheros.jpg'
        ]);
        // Obtener IDs de las categorías para asignarlos a los productos

//
//        $products = [
//            // Desayunos
//            ['name' => 'Huevos Rancheros', 'description' => 'Huevos con salsa ranchera', 'price' => 45.50, 'category_id' => $desayunos->id, 'image_url' => 'url_imagen_huevos_rancheros'],
//            ['name' => 'Panqueques', 'description' => 'Panqueques con miel', 'price' => 40.00, 'category_id' => $desayunos->id, 'image_url' => 'url_imagen_panqueques'],
//
//            // Bebidas y Snacks
//            ['name' => 'Café Americano', 'description' => 'Café filtrado', 'price' => 25.00, 'category_id' => $bebidasSnacks->id, 'image_url' => 'url_imagen_cafe_americano'],
//            ['name' => 'Sandwich', 'description' => 'Sandwich de jamón y queso', 'price' => 35.00, 'category_id' => $bebidasSnacks->id, 'image_url' => 'url_imagen_sandwich'],
//
//            // Comida Corrida
//            ['name' => 'Enchiladas', 'description' => 'Enchiladas verdes con pollo', 'price' => 70.00, 'category_id' => $comidaCorrida->id, 'image_url' => 'url_imagen_enchiladas'],
//            ['name' => 'Milanesa con papas', 'description' => 'Milanesa de res acompañada de papas', 'price' => 85.00, 'category_id' => $comidaCorrida->id, 'image_url' => 'url_imagen_milanesa'],
//
//            // Comida de Todo el Día
//            ['name' => 'Hamburguesa', 'description' => 'Hamburguesa con queso y papas', 'price' => 60.00, 'category_id' => $comidaTodoDia->id, 'image_url' => 'url_imagen_hamburguesa'],
//            ['name' => 'Ensalada César', 'description' => 'Ensalada fresca con aderezo César', 'price' => 55.00, 'category_id' => $comidaTodoDia->id, 'image_url' => 'url_imagen_ensalada'],
//        ];
//
//        foreach ($products as $product) {
//            Product::create($product);
//        }
    }
}
