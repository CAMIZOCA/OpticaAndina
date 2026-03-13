<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Services\SeoService;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $seo = SeoService::forPage('home');
        $seo['schema'] = json_encode(SeoService::localBusinessSchema(), JSON_UNESCAPED_UNICODE);

        $settings = SiteSetting::getAll();

        // Hero data — editable via Configuración → Página Inicio
        $hero = [
            'title'    => $settings['hero_title']    ?? 'Tu visión, nuestro compromiso',
            'subtitle' => $settings['hero_subtitle']  ?? 'Más de 15 años cuidando la salud visual de las familias de Tumbaco. Exámenes visuales, monturas nacionales e importadas, lentes de contacto y mucho más.',
            'cta_text' => $settings['hero_cta_text']  ?? 'Ver Catálogo',
            'cta_link' => route('catalogo'),
        ];

        // About section — editable via Configuración → Página Inicio
        $rawFeatures = $settings['about_features'] ?? null;
        $featuresData = $rawFeatures ? json_decode($rawFeatures, true) : null;
        $aboutFeatures = [];
        if (is_array($featuresData)) {
            $aboutFeatures = array_column($featuresData, 'feature');
        }
        if (empty($aboutFeatures)) {
            $aboutFeatures = [
                'Atención personalizada y profesional',
                'Tecnología moderna para diagnóstico',
                'Lentes certificados de calidad',
                'Seguimiento continuo de tu visión',
            ];
        }

        $about = [
            'content'  => $settings['about_content'] ?? 'En Óptica Vista Andina nos dedicamos a proporcionar cuidado visual profesional y personalizado. Contamos con equipamiento de última generación y un equipo de especialistas certificados.',
            'features' => $aboutFeatures,
        ];

        // Featured products
        $featuredProducts = Product::with(['category', 'brand', 'images'])
            ->active()->available()->featured()->ordered()->limit(8)->get();

        // Services
        $services = Service::active()->ordered()->limit(5)->get();

        // Service gallery (3 main services with images)
        $serviceGallery = Service::active()->ordered()->limit(3)->get();

        // Brands
        $brands = Brand::active()->limit(8)->get();

        // Categories
        $categories = Category::active()->root()->ordered()->get();

        // Latest blog posts
        $latestPosts = BlogPost::published()->latest()->limit(3)->get();

        // Optional models — only query if table exists (safe for projects in progress)
        $stats        = $this->safeQuery('stats',        fn () => \App\Models\Stat::active()->ordered()->get());
        $testimonials = $this->safeQuery('testimonials', fn () => \App\Models\Testimonial::active()->featured()->ordered()->limit(3)->get());
        $faqs         = $this->safeQuery('faqs',         fn () => \App\Models\Faq::active()->ordered()->get());
        $video        = $this->safeQuery('videos',       fn () => \App\Models\Video::ordered()->first());
        $process      = collect([]);

        return view('pages.home', compact(
            'seo',
            'hero',
            'about',
            'services',
            'serviceGallery',
            'featuredProducts',
            'brands',
            'categories',
            'latestPosts',
            'stats',
            'testimonials',
            'faqs',
            'video',
            'process'
        ));
    }

    public function nosotros()
    {
        $seo = SeoService::forPage('nosotros');

        $settings = SiteSetting::getAll();

        // Historia — editable via Configuración → Página Nosotros
        $historia = array_filter([
            $settings['nosotros_historia_1'] ?? 'Óptica Vista Andina nació en Tumbaco con la misión de ofrecer atención visual de calidad a precios accesibles para las familias de nuestra comunidad.',
            $settings['nosotros_historia_2'] ?? 'Con más de 15 años de experiencia, hemos atendido a miles de pacientes, desde niños hasta adultos mayores, ayudándoles a ver el mundo con claridad.',
            $settings['nosotros_historia_3'] ?? 'Contamos con tecnología moderna para exámenes visuales y una amplia selección de monturas nacionales e importadas para todos los gustos y presupuestos.',
        ]);

        // Nosotros image
        $nosotrosImagePath = $settings['nosotros_imagen'] ?? null;
        $nosotrosImageUrl  = $nosotrosImagePath
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($nosotrosImagePath)
            : null;

        // Team members — editable via Configuración → Página Nosotros
        $rawTeam = $settings['nosotros_team'] ?? null;
        $team    = $rawTeam ? json_decode($rawTeam, true) : [];
        if (!is_array($team) || empty($team)) {
            $team = [
                ['name' => 'Especialista Óptico',  'role' => 'Optómetra Certificado',  'photo' => null],
                ['name' => 'Atención al Cliente',  'role' => 'Asesora de Monturas',    'photo' => null],
                ['name' => 'Técnico en Óptica',    'role' => 'Laboratorio de Lentes',  'photo' => null],
            ];
        }

        return view('pages.nosotros', compact('seo', 'historia', 'nosotrosImageUrl', 'team'));
    }

    /**
     * Safely query an optional model — returns default if table does not exist.
     */
    private function safeQuery(string $table, \Closure $query, mixed $default = null): mixed
    {
        try {
            if (!Schema::hasTable($table)) {
                return $default ?? collect([]);
            }
            return $query();
        } catch (\Throwable) {
            return $default ?? collect([]);
        }
    }
}
