<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Desayunos',
            'availability_start' => '8:00 AM',
            'availability_end' => '1:00 PM',
            'available_days' => ['lunes', 'martes', 'miércoles', 'jueves', 'viernes'],
        ]);

        Category::create([
            'name' => 'Comida Corrida',
            'availability_start' => '1:00 PM',
            'availability_end' => '5:30 PM',
            'available_days' => ['lunes', 'martes', 'miércoles', 'jueves', 'viernes'],
        ]);

        Category::create([
            'name' => 'Todo el day',
            'availability_start' => '8:00 AM',
            'availability_end' => '5:30 PM',
            'available_days' => ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'],
        ]);

        Category::create([
            'name' => 'Menus',
        ]);

        Category::create([
            'name' => 'Combos',
        ]);
    }
}
