<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\SiteSetting;
use App\Services\SeoService;

class MediaController extends Controller
{
    public function index()
    {
        $siteName = SiteSetting::get('site_name', 'Optica Andina');
        $media = Media::latest()->paginate(24);

        $seo = SeoService::applyDefaults([
            'title' => 'Galeria | '.$siteName,
            'meta_description' => 'Galeria de imagenes de '.$siteName.', optica en Tumbaco, Ecuador.',
            'og_title' => 'Galeria | '.$siteName,
            'og_description' => 'Fotos y referencias visuales de productos y servicios.',
            'og_image' => '',
            'canonical' => SeoService::canonicalForCurrentRequest(),
            'noindex' => false,
            'schema' => SeoService::collectionPageSchema(
                'Galeria',
                route('galeria'),
                $media->getCollection()->map(fn (Media $item) => [
                    'name' => $item->alt ?: $item->filename,
                    'url' => $item->url,
                    'image' => $item->url,
                ])->all(),
                'Galeria de imagenes de Optica Andina.'
            ),
            'site_name' => $siteName,
        ]);
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Galeria', 'url' => route('galeria')],
        ]);

        return view('pages.galeria.index', compact('seo', 'media'));
    }
}
