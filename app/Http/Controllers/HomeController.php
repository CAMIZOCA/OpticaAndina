<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Service;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\Video;
use App\Services\SeoService;

class HomeController extends Controller
{
    public function index()
    {
        $seo = SeoService::forPage('home');
        $seo['schema'] = json_encode(SeoService::localBusinessSchema(), JSON_UNESCAPED_UNICODE);

        // Hero data
        $hero = [
            'title' => 'Tu visión, nuestro compromiso',
            'subtitle' => 'Más de 15 años cuidando la salud visual de las familias de Tumbaco. Exámenes visuales, monturas nacionales e importadas, lentes de contacto y mucho más.',
            'cta_text' => 'Ver Catálogo',
            'cta_link' => route('catalogo'),
        ];

        // Featured products
        $featuredProducts = Product::with(['category', 'brand', 'images'])
            ->active()->available()->featured()->ordered()->limit(8)->get();

        // Services
        $services = Service::active()->ordered()->limit(5)->get();

        // Stats (social proof)
        $stats = Stat::active()->ordered()->get();

        // About section data
        $about = [
            'content' => 'En Óptica Vista Andina nos dedicamos a proporcionar cuidado visual profesional y personalizado. Contamos con equipamiento de última generación y un equipo de especialistas certificados.',
            'features' => [
                'Atención personalizada y profesional',
                'Tecnología moderna para diagnóstico',
                'Lentes certificados de calidad',
                'Seguimiento continuo de tu visión',
            ],
        ];

        // Process (service flow)
        $process = [];

        // Service gallery (3 main services with images)
        $serviceGallery = Service::active()->ordered()->limit(3)->get();

        // Testimonials
        $testimonials = Testimonial::active()->featured()->ordered()->limit(3)->get();

        // FAQs
        $faqs = Faq::active()->ordered()->get();

        // Video
        $video = Video::ordered()->first();

        // Brands
        $brands = Brand::active()->limit(8)->get();

        // Categories
        $categories = Category::active()->root()->ordered()->get();

        // Latest blog posts
        $latestPosts = BlogPost::published()->latest()->limit(3)->get();

        return view('pages.home', compact(
            'seo',
            'hero',
            'services',
            'stats',
            'about',
            'process',
            'serviceGallery',
            'testimonials',
            'faqs',
            'video',
            'featuredProducts',
            'brands',
            'categories',
            'latestPosts'
        ));
    }

    public function nosotros()
    {
        $seo = SeoService::forPage('nosotros');
        return view('pages.nosotros', compact('seo'));
    }
}
