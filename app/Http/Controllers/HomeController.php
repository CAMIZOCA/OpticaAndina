<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\Video;
use App\Services\SeoService;
use App\Support\MediaUrl;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /** Default section order (used when no override is stored in settings). */
    private const DEFAULT_SECTIONS = [
        ['key' => 'services',          'visible' => true],
        ['key' => 'stats',             'visible' => true],
        ['key' => 'about',             'visible' => true],
        ['key' => 'process',           'visible' => true],
        ['key' => 'service_gallery',   'visible' => true],
        ['key' => 'featured_products', 'visible' => true],
        ['key' => 'brands',            'visible' => true],
        ['key' => 'categories',        'visible' => true],
        ['key' => 'latest_posts',      'visible' => true],
        ['key' => 'faq',               'visible' => true],
    ];

    public function index()
    {
        $seo = SeoService::forPage('home');
        $seo['schema'] = json_encode(SeoService::localBusinessSchema(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $seo['extra_schema'] = SeoService::websiteSchema();

        $settings = SiteSetting::getAll();

        // ── Hero ────────────────────────────────────────────────────────────
        $heroImagePath = $settings['hero_image'] ?? null;
        $hero = [
            'title' => $settings['hero_title'] ?? 'Tu visión, nuestro compromiso',
            'subtitle' => $settings['hero_subtitle'] ?? 'Más de 15 años cuidando la salud visual de las familias de Tumbaco. Exámenes visuales, monturas nacionales e importadas, lentes de contacto y mucho más.',
            'cta_text' => $settings['hero_cta_text'] ?? 'Ver Catálogo',
            'cta_link' => route('catalogo'),
            'image' => MediaUrl::image($heroImagePath),
        ];

        // ── About section ───────────────────────────────────────────────────
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
        $aboutImagePath = $settings['about_image'] ?? null;
        $about = [
            'title' => $settings['about_title'] ?? 'Cuidado profesional y personalizado',
            'content' => $settings['about_content'] ?? 'En Óptica Andina nos dedicamos a proporcionar cuidado visual profesional y personalizado. Contamos con equipamiento de última generación y un equipo de especialistas certificados.',
            'features' => $aboutFeatures,
            'image' => MediaUrl::image($aboutImagePath),
        ];

        // ── Process ─────────────────────────────────────────────────────────
        $rawProcess = $settings['home_process'] ?? null;
        $process = $rawProcess ? json_decode($rawProcess, true) : [];
        if (! is_array($process)) {
            $process = [];
        }

        // ── Articles count ──────────────────────────────────────────────────
        $articlesCount = (int) ($settings['home_articles_count'] ?? 3);

        // ── Section ordering ────────────────────────────────────────────────
        $rawOrder = $settings['home_sections_order'] ?? null;
        $sections = $rawOrder ? json_decode($rawOrder, true) : null;
        if (! is_array($sections) || empty($sections)) {
            $sections = self::DEFAULT_SECTIONS;
        }
        // Only include sections with visible = true
        $sections = array_values(array_filter(
            $sections,
            fn ($s) => (bool) ($s['visible'] ?? true)
        ));

        // ── Dynamic data queries ─────────────────────────────────────────────
        $neededSectionKeys = array_column($sections, 'key');

        $services = in_array('services', $neededSectionKeys) || in_array('service_gallery', $neededSectionKeys)
            ? $this->safeQuery('services', fn () => Service::active()->ordered()->get())
            : collect();

        $serviceGallery = $services->take(3);
        $services = $services->take(5);

        $stats = in_array('stats', $neededSectionKeys)
            ? $this->safeQuery('stats', fn () => Stat::active()->ordered()->get())
            : collect();

        $featuredProducts = in_array('featured_products', $neededSectionKeys)
            ? $this->safeQuery('products', fn () => Product::with(['category', 'brand', 'images'])->active()->available()->featured()->ordered()->limit(8)->get())
            : collect();

        $brands = in_array('brands', $neededSectionKeys)
            ? $this->safeQuery('brands', fn () => Brand::active()->limit(8)->get())
            : collect();

        $categories = in_array('categories', $neededSectionKeys)
            ? $this->safeQuery('categories', fn () => Category::active()->root()->ordered()->get())
            : collect();

        $latestPosts = in_array('latest_posts', $neededSectionKeys)
            ? $this->safeQuery('blog_posts', fn () => BlogPost::published()->latest()->limit($articlesCount)->get())
            : collect();

        $faqs = in_array('faq', $neededSectionKeys)
            ? $this->safeQuery('faq', fn () => Faq::active()->ordered()->get())
            : collect();

        // Optional: testimonials, video (future)
        $testimonials = $this->safeQuery('testimonials', fn () => Testimonial::active()->featured()->ordered()->limit(3)->get());
        $video = $this->safeQuery('videos', fn () => Video::ordered()->first());

        return view('pages.home', compact(
            'seo',
            'hero',
            'about',
            'process',
            'sections',
            'services',
            'serviceGallery',
            'stats',
            'featuredProducts',
            'brands',
            'categories',
            'latestPosts',
            'articlesCount',
            'faqs',
            'testimonials',
            'video'
        ));
    }

    public function nosotros()
    {
        $seo = SeoService::forPage('nosotros');
        $settings = SiteSetting::getAll();

        $historia = array_filter([
            $settings['nosotros_historia_1'] ?? 'Óptica Andina nació en Tumbaco con la misión de ofrecer atención visual de calidad a precios accesibles para las familias de nuestra comunidad.',
            $settings['nosotros_historia_2'] ?? 'Con más de 15 años de experiencia, hemos atendido a miles de pacientes, desde niños hasta adultos mayores, ayudándoles a ver el mundo con claridad.',
            $settings['nosotros_historia_3'] ?? 'Contamos con tecnología moderna para exámenes visuales y una amplia selección de monturas nacionales e importadas para todos los gustos y presupuestos.',
        ]);

        $nosotrosImagePath = $settings['nosotros_imagen'] ?? null;
        $nosotrosImageUrl = MediaUrl::image($nosotrosImagePath);

        $rawTeam = $settings['nosotros_team'] ?? null;
        $team = $rawTeam ? json_decode($rawTeam, true) : [];
        if (! is_array($team) || empty($team)) {
            $team = [
                ['name' => 'Especialista Óptico',  'role' => 'Optómetra Certificado',  'photo' => null],
                ['name' => 'Atención al Cliente',  'role' => 'Asesora de Monturas',    'photo' => null],
                ['name' => 'Técnico en Óptica',    'role' => 'Laboratorio de Lentes',  'photo' => null],
            ];
        }

        $siteName = SiteSetting::get('site_name', 'Óptica Andina');
        $seo['schema'] = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'AboutPage',
            'url' => route('nosotros'),
            'name' => 'Nosotros – '.$siteName,
            'description' => SiteSetting::get('seo_description', ''),
            'mainEntity' => [
                '@type' => 'Organization',
                'name' => $siteName,
                '@id' => config('app.url').'/#business',
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Nosotros', 'url' => route('nosotros')],
        ]);

        return view('pages.nosotros', compact('seo', 'historia', 'nosotrosImageUrl', 'team'));
    }

    /**
     * Safely query an optional model — returns default if table does not exist.
     */
    private function safeQuery(string $table, \Closure $query, mixed $default = null): mixed
    {
        try {
            if (! Schema::hasTable($table)) {
                return $default ?? collect();
            }

            return $query();
        } catch (\Throwable) {
            return $default ?? collect();
        }
    }
}
