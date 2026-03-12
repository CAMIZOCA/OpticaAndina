<?php

namespace Database\Seeders;

use App\Models\SeoMeta;
use Illuminate\Database\Seeder;

class SeoMetaSeeder extends Seeder
{
    public function run(): void
    {
        $metas = [
            [
                'page_key'         => 'home',
                'title'            => 'Óptica Vista Andina – Tumbaco, Quito, Ecuador',
                'meta_description' => 'Óptica en Tumbaco con más de 10 años de experiencia. Exámenes visuales, lentes de contacto, monturas de marca y mucho más. ¡Visítanos!',
                'og_title'         => 'Óptica Vista Andina – Tumbaco, Ecuador',
                'og_description'   => 'Tu óptica de confianza en Tumbaco. Exámenes visuales, lentes de contacto y las mejores marcas en monturas.',
            ],
            [
                'page_key'         => 'nosotros',
                'title'            => 'Quiénes Somos – Óptica Vista Andina Tumbaco',
                'meta_description' => 'Conoce a nuestro equipo de optometristas en Tumbaco, Ecuador. Más de 10 años cuidando la salud visual de tu familia.',
                'og_title'         => 'Sobre Óptica Vista Andina',
                'og_description'   => 'Somos una óptica familiar en Tumbaco dedicada a cuidar la salud visual de toda tu familia.',
            ],
            [
                'page_key'         => 'servicios',
                'title'            => 'Servicios de Optometría en Tumbaco – Óptica Vista Andina',
                'meta_description' => 'Examen visual integral, adaptación de lentes de contacto, terapia visual y más servicios optométricos en Tumbaco, Ecuador.',
                'og_title'         => 'Servicios Optométricos – Óptica Vista Andina',
                'og_description'   => 'Desde exámenes visuales hasta terapia visual, ofrecemos servicios completos de optometría en Tumbaco.',
            ],
            [
                'page_key'         => 'catalogo',
                'title'            => 'Catálogo de Monturas y Lentes – Óptica Vista Andina Tumbaco',
                'meta_description' => 'Explora nuestro catálogo de monturas, lentes de sol y lentes de contacto en Tumbaco, Ecuador. Consulta por WhatsApp.',
                'og_title'         => 'Catálogo – Óptica Vista Andina',
                'og_description'   => 'Monturas para hombre, mujer e infantiles. Gafas de sol y lentes de contacto en Tumbaco, Ecuador.',
            ],
            [
                'page_key'         => 'blog',
                'title'            => 'Blog de Salud Visual – Óptica Vista Andina',
                'meta_description' => 'Artículos y consejos sobre salud visual, cuidado de los ojos y novedades en optometría. Escrito por nuestros especialistas.',
                'og_title'         => 'Blog – Óptica Vista Andina',
                'og_description'   => 'Consejos de salud visual y novedades en optometría de nuestros especialistas en Tumbaco.',
            ],
            [
                'page_key'         => 'contacto',
                'title'            => 'Contacto – Óptica Vista Andina Tumbaco',
                'meta_description' => 'Contáctanos o visítanos en Tumbaco, Ecuador. Horario de atención, dirección y formulario de contacto.',
                'og_title'         => 'Contacto – Óptica Vista Andina',
                'og_description'   => 'Encuéntranos en Tumbaco, Ecuador. Lunes a viernes 9:00–18:00, sábados 9:00–14:00.',
            ],
        ];

        foreach ($metas as $meta) {
            SeoMeta::updateOrCreate(['page_key' => $meta['page_key']], $meta);
        }
    }
}
