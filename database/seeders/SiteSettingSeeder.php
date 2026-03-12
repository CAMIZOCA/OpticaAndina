<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // general
            ['key' => 'site_name',        'value' => 'Óptica Vista Andina',                            'group' => 'general'],
            ['key' => 'site_tagline',     'value' => 'Tu visión, nuestra misión',                      'group' => 'general'],
            ['key' => 'founding_year',    'value' => '2010',                                           'group' => 'general'],

            // contact
            ['key' => 'address',          'value' => 'Av. Interoceánica, Tumbaco, Pichincha, Ecuador', 'group' => 'contact'],
            ['key' => 'phone',            'value' => '+593 2 289-0000',                                'group' => 'contact'],
            ['key' => 'whatsapp_number',  'value' => '593999000000',                                   'group' => 'contact'],
            ['key' => 'whatsapp_message', 'value' => 'Hola, me gustaría obtener más información.',     'group' => 'contact'],
            ['key' => 'email',            'value' => 'info@opticavistaandina.com',                     'group' => 'contact'],
            ['key' => 'hours',            'value' => 'Lun–Vie 9:00–18:00 | Sáb 9:00–14:00',          'group' => 'contact'],
            ['key' => 'maps_url',         'value' => 'https://maps.google.com',                        'group' => 'contact'],
            ['key' => 'maps_embed',       'value' => '',                                               'group' => 'contact'],

            // seo
            ['key' => 'seo_title',        'value' => 'Óptica Vista Andina – Tumbaco, Ecuador',        'group' => 'seo'],
            ['key' => 'seo_description',  'value' => 'Óptica en Tumbaco especializada en exámenes visuales, lentes de contacto y monturas de marca. Atención personalizada cerca de Quito.', 'group' => 'seo'],
            ['key' => 'og_image',         'value' => '',                                               'group' => 'seo'],
            ['key' => 'google_analytics', 'value' => '',                                               'group' => 'seo'],

            // social
            ['key' => 'facebook_url',     'value' => '',                                               'group' => 'social'],
            ['key' => 'instagram_url',    'value' => '',                                               'group' => 'social'],
            ['key' => 'tiktok_url',       'value' => '',                                               'group' => 'social'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
