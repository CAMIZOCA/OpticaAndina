<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => '¿Cuánto tiempo dura un examen visual completo?',
                'answer' => 'Un examen visual integral generalmente toma entre 30 a 45 minutos. Este tiempo incluye la prueba de agudeza visual, medición de presión intraocular, evaluación de la salud de la retina y otras pruebas necesarias según tu caso.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question' => '¿Con qué frecuencia debo hacer exámenes visuales?',
                'answer' => 'Se recomienda hacer un examen visual completo cada año para adultos sin problemas visuales. Si tienes condiciones previas como miopía, astigmatismo o presión ocular elevada, consulta con nuestros especialistas sobre la frecuencia apropiada para tu caso.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question' => '¿Necesito una referencia médica para agendar una cita?',
                'answer' => 'No necesitas una referencia médica para agendar un examen visual. Puedes venir directamente o agendar en línea. Sin embargo, si tu médico general te ha referido, trae la referencia para que tengamos información del motivo de la consulta.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'question' => '¿Cuál es la diferencia entre lentes de contacto blandas y rígidas?',
                'answer' => 'Las lentes de contacto blandas son más cómodas para iniciarse y permiten que entra más oxígeno. Las rígidas ofrecen mejor corrección en algunos casos de astigmatismo alto. Nuestro equipo puede recomendarte la opción más adecuada después de evaluar tu caso.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'question' => '¿Ofrecen servicio de terapia visual?',
                'answer' => 'Sí, ofrecemos servicios de terapia visual y entrenamiento ocular. Estos servicios son especialmente útiles para personas con problemas de enfoque, coordinación visual o ambigüedad. Consúltanos para más información.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'question' => '¿Cuáles son sus horarios de atención?',
                'answer' => 'Nuestro horario es de lunes a viernes de 9:00 AM a 6:00 PM, y sábados de 9:00 AM a 2:00 PM. Los domingos permanecemos cerrados. Te recomendamos agendar con anticipación para asegurar tu cita.',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'question' => '¿Aceptan seguros médicos?',
                'answer' => 'Sí, trabajamos con varios seguros médicos. Te recomendamos contactarnos o llamar antes de tu cita para verificar si tu seguro es aceptado y conocer los detalles de cobertura.',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'question' => '¿Puedo comprar lentes en línea y solo venir por el examen?',
                'answer' => 'Para obtener la prescripción correcta, es necesario realizar un examen visual con nosotros. Sin embargo, una vez tengas tu prescripción, puedes adquirir tus lentes en nuestro local o explorar otras opciones. Siempre recomendamos comprar lentes en ópticas certificadas.',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
