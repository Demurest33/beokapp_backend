<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductOption;
use App\Models\OptionValue;

class ProductOptionSeeder extends Seeder
{
    public function run()
    {
        // Crear opción "Tamaño"
        $sizeOption = ProductOption::create(['name' => 'Tamaño']);

        // Crear valores para la opción "Tamaño"
        OptionValue::create(['value' => 'Chico', 'product_option_id' => $sizeOption->id]);
        OptionValue::create(['value' => 'Grande', 'product_option_id' => $sizeOption->id]);

        // Crear opción "Sabor"
        $flavorOption = ProductOption::create(['name' => 'Sabor']);

        // Crear valores para la opción "Sabor"
        OptionValue::create(['value' => 'Miel', 'product_option_id' => $flavorOption->id]);
        OptionValue::create(['value' => 'Mantequilla', 'product_option_id' => $flavorOption->id]);
    }
}
