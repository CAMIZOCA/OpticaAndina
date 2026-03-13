<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Ray-Ban', 'slug' => 'ray-ban', 'country' => 'Italy', 'description' => 'Marca internacional de monturas y gafas solares.'],
            ['name' => 'Converse', 'slug' => 'converse', 'country' => 'United States', 'description' => 'Marca de estilo urbano con linea de eyewear casual.'],
            ['name' => 'Adidas', 'slug' => 'adidas', 'country' => 'Germany', 'description' => 'Marca deportiva internacional con colecciones de eyewear.'],
            ['name' => 'Puma', 'slug' => 'puma', 'country' => 'Germany', 'description' => 'Marca deportiva con monturas y gafas de estilo activo.'],
            ['name' => 'Guess', 'slug' => 'guess', 'country' => 'United States', 'description' => 'Marca de moda con disenos modernos en eyewear.'],
            ['name' => 'Mormaii', 'slug' => 'mormaii', 'country' => 'Brazil', 'description' => 'Marca brasilena enfocada en estilo deportivo y playa.'],
            ['name' => 'Linea Roma', 'slug' => 'linea-roma', 'country' => 'Italy', 'description' => 'Linea de monturas de inspiracion clasica y elegante.'],
            ['name' => 'Tommy Hilfiger', 'slug' => 'tommy-hilfiger', 'country' => 'United States', 'description' => 'Marca de moda premium con colecciones de eyewear.'],
            ['name' => 'Gildi Eyewear', 'slug' => 'gildi-eyewear', 'country' => 'International', 'description' => 'Marca de eyewear con modelos funcionales y contemporaneos.'],
            ['name' => 'Columbia Eyewear', 'slug' => 'columbia-eyewear', 'country' => 'United States', 'description' => 'Eyewear orientado a actividades outdoor y uso diario.'],
            ['name' => 'Timberland', 'slug' => 'timberland', 'country' => 'United States', 'description' => 'Marca reconocida por diseno robusto y estilo outdoor.'],
            ['name' => 'Nano Vista', 'slug' => 'nano-vista', 'country' => 'Spain', 'description' => 'Marca especializada en monturas resistentes para ninos.'],
            ['name' => 'Leader Sports', 'slug' => 'leader-sports', 'country' => 'United States', 'description' => 'Marca deportiva con enfoque en comodidad y rendimiento.'],
            ['name' => 'Ines de la Fressange', 'slug' => 'ines-de-la-fressange', 'country' => 'France', 'description' => 'Marca francesa de estilo sofisticado y femenino.'],
            ['name' => 'Platini', 'slug' => 'platini', 'country' => 'International', 'description' => 'Marca de monturas con estilo clasico y ejecutivo.'],
            ['name' => 'Ralph Lauren', 'slug' => 'ralph-lauren', 'country' => 'United States', 'description' => 'Marca de lujo con colecciones elegantes de eyewear.'],
            ['name' => 'Miraflex', 'slug' => 'miraflex', 'country' => 'Italy', 'description' => 'Marca infantil reconocida por monturas flexibles y seguras.'],
            ['name' => 'Polar Sunglasses', 'slug' => 'polar-sunglasses', 'country' => 'Spain', 'description' => 'Marca enfocada en lentes solares con proteccion polarizada.'],
            ['name' => 'United Colors of Benetton', 'slug' => 'united-colors-of-benetton', 'country' => 'Italy', 'description' => 'Marca de moda con disenos coloridos y juveniles.'],
            ['name' => 'Kenneth Cole Reaction', 'slug' => 'kenneth-cole-reaction', 'country' => 'United States', 'description' => 'Linea contemporanea con estilo urbano y versatil.'],
            ['name' => 'Aspire', 'slug' => 'aspire', 'country' => 'International', 'description' => 'Marca de eyewear con propuesta moderna y ligera.'],
            ['name' => 'Jean Monnier', 'slug' => 'jean-monnier', 'country' => 'France', 'description' => 'Marca de estilo europeo con enfoque clasico.'],
            ['name' => 'Vogue Eyewear', 'slug' => 'vogue-eyewear', 'country' => 'Italy', 'description' => 'Marca de moda internacional con disenos en tendencia.'],
            ['name' => 'H&M', 'slug' => 'h-and-m', 'country' => 'Sweden', 'description' => 'Marca global de moda con opciones accesibles de eyewear.'],
            ['name' => 'Swarovski', 'slug' => 'swarovski', 'country' => 'Austria', 'description' => 'Marca premium con detalles refinados y estilo elegante.'],
            ['name' => 'Calvin Klein', 'slug' => 'calvin-klein', 'country' => 'United States', 'description' => 'Marca minimalista con monturas de diseno moderno.'],
            ['name' => 'SBK Official Eyewear', 'slug' => 'sbk-official-eyewear', 'country' => 'Italy', 'description' => 'Eyewear de estilo deportivo inspirado en motociclismo.'],
            ['name' => 'Champion', 'slug' => 'champion', 'country' => 'United States', 'description' => 'Marca deportiva iconica con lineas urbanas y activas.'],
            ['name' => 'Artistik Eyewear', 'slug' => 'artistik-eyewear', 'country' => 'International', 'description' => 'Marca de monturas con enfoque creativo y diferenciador.'],
            ['name' => 'Dicaprio', 'slug' => 'dicaprio', 'country' => 'International', 'description' => 'Marca de eyewear con propuestas casuales y formales.'],
            ['name' => 'Mimito', 'slug' => 'mimito', 'country' => 'Peru', 'description' => 'Marca infantil con disenos amigables y coloridos.'],
            ['name' => 'OA Eyewear', 'slug' => 'oa-eyewear', 'country' => 'Ecuador', 'description' => 'Marca de eyewear comercializada localmente por Optica Andina.'],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['slug' => $brand['slug']],
                [
                    'name' => $brand['name'],
                    'country' => $brand['country'],
                    'description' => $brand['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
