<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'María García',
                'photo' => null,
                'rating' => 5,
                'text' => 'Excelente atención y profesionalismo. El equipo es muy amable y los exámenes visuales son completos. Recomiendo ampliamente a Óptica Andina.',
                'date' => now()->subDays(30),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Juan Ramírez',
                'photo' => null,
                'rating' => 5,
                'text' => 'Llevo varios años viendo aquí. Son expertos en lo suyo. Mis hijos también han hecho sus exámenes visuales regularmente. Muy recomendado.',
                'date' => now()->subDays(45),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Sandra López',
                'photo' => null,
                'rating' => 5,
                'text' => 'Encontré las mejores monturas aquí y la asesoría fue impeccable. El personal conoce mucho sobre óptica. Definitivamente vuelvo.',
                'date' => now()->subDays(60),
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Ricardo Morales',
                'photo' => null,
                'rating' => 4,
                'text' => 'Buen servicio y variedad de productos. Precios justos. Muy contento con las lentes que me recomendaron.',
                'date' => now()->subDays(15),
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Patricia Ruiz',
                'photo' => null,
                'rating' => 5,
                'text' => 'Mi hija necesitaba lentes de contacto y el equipo fue muy paciente en explicar cómo ponerlas y cuidarlas. Excelente servicio al cliente.',
                'date' => now()->subDays(25),
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::firstOrCreate(['name' => $testimonial['name']], $testimonial);
        }
    }
}
