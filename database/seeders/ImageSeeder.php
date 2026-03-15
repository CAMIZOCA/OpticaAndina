<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Downloading sample images via artisan images:seed...');
        Artisan::call('images:seed', [], $this->command->getOutput());
    }
}
