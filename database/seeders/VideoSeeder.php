<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Video::firstOrCreate(
            ['title' => 'Conoce nuestras instalaciones'],
            [
                'title' => 'Conoce nuestras instalaciones',
                'url' => 'https://www.youtube.com/watch?v=TgwDpC4xj30',
                'thumbnail' => null,
                'description' => 'Te invitamos a visitar virtualmente nuestras modernas instalaciones en Tumbaco, Ecuador. Conoce cómo trabajamos y el ambiente donde te atenderemos.',
                'sort_order' => 1,
            ]
        );
    }
}
