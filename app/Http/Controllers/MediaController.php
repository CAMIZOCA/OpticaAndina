<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\SiteSetting;
use App\Services\SeoService;

class MediaController extends Controller
{
    public function index()
    {
        $siteName = SiteSetting::get('site_name', 'Óptica Andina');
        $seo = [
            'title'            => 'Galería – ' . $siteName,
            'meta_description' => 'Galería de imágenes de ' . $siteName . ', óptica en Tumbaco, Ecuador.',
            'og_title'         => 'Galería – ' . $siteName,
            'og_description'   => '',
            'og_image'         => '',
            'canonical'        => null,
            'noindex'          => false,
            'schema'           => null,
            'site_name'        => $siteName,
        ];
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Galería', 'url' => route('galeria')],
        ]);

        $media = Media::latest()->paginate(24);

        return view('pages.galeria.index', compact('seo', 'media'));
    }
}
