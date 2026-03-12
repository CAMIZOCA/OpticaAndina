<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title'              => 'Examen Visual Integral',
                'slug'               => 'examen-visual-integral',
                'excerpt'            => 'Evaluación completa de la salud visual con equipos de última generación.',
                'content'            => '<p>Nuestro examen visual integral evalúa la agudeza visual, la refracción ocular, la presión intraocular y el estado general del ojo. Contamos con tecnología de punta para garantizar un diagnóstico preciso.</p>',
                'icon'               => 'heroicon-o-eye',
                'cta_text'           => 'Agenda tu examen',
                'cta_whatsapp_text'  => 'Hola, quisiera agendar un examen visual integral. ¿Cuál es su disponibilidad?',
                'sort_order'         => 1,
                'faqs'               => [
                    ['question' => '¿Con qué frecuencia debo hacerme un examen visual?', 'answer' => 'Se recomienda un examen visual completo cada año, o con mayor frecuencia si tiene problemas visuales o usa lentes de corrección.'],
                    ['question' => '¿El examen tiene algún costo?', 'answer' => 'Consulta nuestros precios actuales. El examen es sin costo cuando adquieres tus lentes con nosotros.'],
                ],
                'meta_title'         => 'Examen Visual Integral – Óptica Vista Andina Tumbaco',
                'meta_description'   => 'Examen visual completo en Tumbaco, Ecuador. Diagnóstico preciso con equipos modernos. ¡Agenda tu cita hoy!',
            ],
            [
                'title'              => 'Adaptación de Lentes de Contacto',
                'slug'               => 'adaptacion-lentes-contacto',
                'excerpt'            => 'Evaluación y adaptación personalizada de lentes de contacto blandos y rígidos.',
                'content'            => '<p>Realizamos un estudio completo de la córnea para recomendar el tipo de lente de contacto más adecuado para tu estilo de vida y necesidades visuales.</p>',
                'icon'               => 'heroicon-o-adjustments-horizontal',
                'cta_text'           => 'Consultar adaptación',
                'cta_whatsapp_text'  => 'Hola, me interesa la adaptación de lentes de contacto. ¿Podría obtener más información?',
                'sort_order'         => 2,
                'faqs'               => [
                    ['question' => '¿Puedo usar lentes de contacto si tengo astigmatismo?', 'answer' => 'Sí, existen lentes tóricos especialmente diseñados para corregir el astigmatismo.'],
                ],
                'meta_title'         => 'Lentes de Contacto en Tumbaco – Óptica Vista Andina',
                'meta_description'   => 'Adaptación de lentes de contacto blandos y rígidos en Tumbaco, Ecuador.',
            ],
            [
                'title'              => 'Terapia Visual',
                'slug'               => 'terapia-visual',
                'excerpt'            => 'Tratamiento personalizado para mejorar las habilidades visuales y la coordinación ojo-cerebro.',
                'content'            => '<p>La terapia visual es un programa de ejercicios diseñados para mejorar la eficiencia del sistema visual, especialmente útil en problemas de convergencia, estrabismo funcional y dificultades de lectura.</p>',
                'icon'               => 'heroicon-o-academic-cap',
                'cta_text'           => 'Más información',
                'cta_whatsapp_text'  => 'Hola, quisiera información sobre terapia visual. ¿A quiénes está dirigida?',
                'sort_order'         => 3,
                'faqs'               => [],
                'meta_title'         => 'Terapia Visual en Tumbaco – Óptica Vista Andina',
                'meta_description'   => 'Terapia visual personalizada para niños y adultos en Tumbaco, Ecuador.',
            ],
            [
                'title'              => 'Baja Visión',
                'slug'               => 'baja-vision',
                'excerpt'            => 'Evaluación y rehabilitación visual para personas con discapacidad visual.',
                'content'            => '<p>Nuestros especialistas en baja visión evalúan el potencial visual residual y prescriben ayudas ópticas para mejorar la calidad de vida de personas con discapacidad visual.</p>',
                'icon'               => 'heroicon-o-magnifying-glass',
                'cta_text'           => 'Consultar',
                'cta_whatsapp_text'  => 'Hola, quisiera información sobre el servicio de baja visión.',
                'sort_order'         => 4,
                'faqs'               => [],
                'meta_title'         => 'Baja Visión – Óptica Vista Andina Tumbaco',
                'meta_description'   => 'Rehabilitación visual para personas con baja visión en Tumbaco, Ecuador.',
            ],
            [
                'title'              => 'Asesoría en Monturas',
                'slug'               => 'asesoria-monturas',
                'excerpt'            => 'Te ayudamos a elegir la montura perfecta según tu forma de rostro y estilo de vida.',
                'content'            => '<p>Nuestros asesores te guiarán en la selección de la montura ideal, considerando tu anatomía facial, el tipo de lente que necesitas y tu personalidad.</p>',
                'icon'               => 'heroicon-o-sparkles',
                'cta_text'           => 'Ver catálogo',
                'cta_whatsapp_text'  => 'Hola, me gustaría recibir asesoría para elegir una montura. ¿Cuándo puedo visitarlos?',
                'sort_order'         => 5,
                'faqs'               => [],
                'meta_title'         => 'Asesoría en Monturas – Óptica Vista Andina',
                'meta_description'   => 'Encuentra la montura perfecta para tu rostro en Tumbaco, Ecuador.',
            ],
            [
                'title'              => 'Control Visual Infantil',
                'slug'               => 'control-visual-infantil',
                'excerpt'            => 'Revisiones visuales especializadas para niños desde los 3 años.',
                'content'            => '<p>La detección temprana de problemas visuales es clave para el desarrollo escolar y cognitivo del niño. Ofrecemos exámenes visuales adaptados a cada etapa del desarrollo infantil.</p>',
                'icon'               => 'heroicon-o-face-smile',
                'cta_text'           => 'Agendar cita',
                'cta_whatsapp_text'  => 'Hola, quisiera agendar un control visual para mi hijo/a. ¿Desde qué edad atienden?',
                'sort_order'         => 6,
                'faqs'               => [
                    ['question' => '¿A qué edad se recomienda el primer examen visual?', 'answer' => 'El primer examen visual completo se recomienda alrededor de los 3 años, antes de iniciar la etapa preescolar.'],
                ],
                'meta_title'         => 'Control Visual Infantil en Tumbaco – Óptica Vista Andina',
                'meta_description'   => 'Exámenes visuales para niños en Tumbaco, Ecuador. Detección temprana de problemas oculares.',
            ],
            [
                'title'              => 'Lentes Oftálmicos y Tratamientos',
                'slug'               => 'lentes-oftalmicos',
                'excerpt'            => 'Lentes monofocales, bifocales y progresivos con los mejores tratamientos del mercado.',
                'content'            => '<p>Trabajamos con las principales marcas de lentes oftálmicos para ofrecerte la mejor calidad óptica. Contamos con lentes antirreflejantes, fotosensibles, endurecidos y de alta resistencia.</p>',
                'icon'               => 'heroicon-o-swatch',
                'cta_text'           => 'Consultar',
                'cta_whatsapp_text'  => 'Hola, me interesa información sobre lentes oftálmicos. ¿Qué tratamientos ofrecen?',
                'sort_order'         => 7,
                'faqs'               => [],
                'meta_title'         => 'Lentes Oftálmicos en Tumbaco – Óptica Vista Andina',
                'meta_description'   => 'Lentes monofocales, bifocales y progresivos en Tumbaco, Ecuador. Los mejores tratamientos.',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], array_merge($service, ['is_active' => true]));
        }
    }
}
