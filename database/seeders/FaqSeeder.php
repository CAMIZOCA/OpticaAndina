<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question'   => '¿Cuánto dura un examen visual completo?',
                'answer'     => 'Un examen visual integral en nuestra óptica dura entre 30 y 45 minutos. Durante ese tiempo evaluamos la agudeza visual, la salud ocular, la presión intraocular y la necesidad de corrección óptica. Te recomendamos reservar cita con anticipación.',
                'sort_order' => 1,
                'is_active'  => true,
            ],
            [
                'question'   => '¿Con qué frecuencia debo hacerme un examen visual?',
                'answer'     => 'Lo ideal es realizar un examen visual completo cada año. Sin embargo, si usas lentes correctivos, tienes antecedentes de enfermedades oculares o notas cambios en tu visión, te recomendamos acudir con mayor frecuencia. En niños es especialmente importante no saltarse las revisiones anuales.',
                'sort_order' => 2,
                'is_active'  => true,
            ],
            [
                'question'   => '¿Trabajan con tarjetas de crédito o facilidades de pago?',
                'answer'     => 'Aceptamos las principales tarjetas de crédito y débito. También ofrecemos facilidades de pago directo para que el costo no sea un obstáculo para cuidar tu visión. Consulta con nuestro equipo sobre las opciones disponibles en tu visita.',
                'sort_order' => 3,
                'is_active'  => true,
            ],
            [
                'question'   => '¿Atienden a niños para exámenes visuales?',
                'answer'     => 'Por supuesto. Atendemos a toda la familia, incluidos niños desde los 3 años. De hecho, recomendamos hacer el primer examen visual antes de que el niño ingrese a la escuela para detectar a tiempo problemas como miopía, hipermetropía o ambliopía (ojo vago), que son mucho más fáciles de tratar en edad temprana.',
                'sort_order' => 4,
                'is_active'  => true,
            ],
            [
                'question'   => '¿Cuánto tiempo tarda en estar listo un par de lentes?',
                'answer'     => 'Los lentes monofocales estándar suelen estar listos en 3 a 5 días hábiles. Los lentes progresivos o con tratamientos especiales (antirreflex, fotocromáticos, etc.) pueden tardar entre 5 y 10 días hábiles. Te avisaremos cuando estén listos para retirar.',
                'sort_order' => 5,
                'is_active'  => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
