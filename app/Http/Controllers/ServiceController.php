<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\SeoService;

class ServiceController extends Controller
{
    public function index()
    {
        $seo      = SeoService::forPage('servicios');
        $services = Service::active()->ordered()->get();
        return view('pages.servicios.index', compact('seo', 'services'));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $seo     = SeoService::forService($service);
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Servicios', 'url' => route('servicios')],
            ['name' => $service->title],
        ]);
        $related = Service::active()->ordered()->where('id', '!=', $service->id)->limit(3)->get();
        return view('pages.servicios.show', compact('seo', 'service', 'related'));
    }
}
