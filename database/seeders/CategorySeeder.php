<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Lentes de Hombre',    'slug' => 'lentes-hombre',     'sort_order' => 1, 'meta_title' => 'Lentes para Hombre – Óptica Andina',    'meta_description' => 'Monturas y lentes oftálmicos para hombre en Tumbaco, Ecuador.'],
            ['name' => 'Lentes de Mujer',     'slug' => 'lentes-mujer',      'sort_order' => 2, 'meta_title' => 'Lentes para Mujer – Óptica Andina',     'meta_description' => 'Monturas y lentes oftálmicos para mujer en Tumbaco, Ecuador.'],
            ['name' => 'Lentes Infantiles',   'slug' => 'lentes-infantiles', 'sort_order' => 3, 'meta_title' => 'Lentes Infantiles – Óptica Andina',     'meta_description' => 'Lentes oftálmicos para niños en Tumbaco, Ecuador.'],
            ['name' => 'Gafas de Sol',        'slug' => 'gafas-sol',         'sort_order' => 4, 'meta_title' => 'Gafas de Sol – Óptica Andina',          'meta_description' => 'Gafas de sol con protección UV en Tumbaco, Ecuador.'],
            ['name' => 'Lentes Deportivos',   'slug' => 'lentes-deportivos', 'sort_order' => 5, 'meta_title' => 'Lentes Deportivos – Óptica Andina',     'meta_description' => 'Lentes y gafas deportivas en Tumbaco, Ecuador.'],
            ['name' => 'Lentes de Contacto',  'slug' => 'lentes-contacto',   'sort_order' => 6, 'meta_title' => 'Lentes de Contacto – Óptica Andina',    'meta_description' => 'Lentes de contacto blandos y rígidos en Tumbaco, Ecuador.'],
            ['name' => 'Accesorios',           'slug' => 'accesorios',         'sort_order' => 7, 'meta_title' => 'Accesorios para Óptica – Óptica Andina',  'meta_description' => 'Estuches, cordones, paños y accesorios para gafas en Tumbaco, Ecuador.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], array_merge($category, ['is_active' => true]));
        }
    }
}
