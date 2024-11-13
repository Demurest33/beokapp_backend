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
            'availability_start' => '07:00:00',
            'availability_end' => '11:00:00',
            'available_days' => ['lunes', 'martes', 'miércoles', 'jueves', 'viernes'],
        ]);

        Category::create([
            'name' => 'Bebidas y Snacks',
            'availability_start' => '09:00:00',
            'availability_end' => '18:00:00',
            'available_days' => ['lunes', 'martes', 'miércoles', 'jueves', 'viernes'],
        ]);

        Category::create([
            'name' => 'Comida Corrida',
            'availability_start' => '12:00:00',
            'availability_end' => '15:00:00',
            'available_days' => ['lunes', 'martes', 'miércoles', 'jueves', 'viernes'],
        ]);

        Category::create([
            'name' => 'Comida Todo el Día',
            'availability_start' => '07:00:00',
            'availability_end' => '20:00:00',
            'available_days' => ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'],
        ]);
    }
}
