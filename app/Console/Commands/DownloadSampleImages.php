<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadSampleImages extends Command
{
    protected $signature = 'images:seed {--force : Re-download images that already exist}';
    protected $description = 'Download free sample images from Picsum Photos and Clearbit for all content';

    /** Base URL for Picsum Photos (CC0 licensed via Unsplash) */
    private const PICSUM = 'https://picsum.photos/seed/{seed}/{w}/{h}';

    /** Base URL for Clearbit Logo API (free) */
    private const CLEARBIT = 'https://logo.clearbit.com/{domain}';

    public function handle(): int
    {
        $this->info('📷  Downloading sample images...');
        $this->newLine();

        $this->downloadBlogImages();
        $this->downloadServiceImages();
        $this->downloadCategoryImages();
        $this->downloadBrandLogos();
        $this->downloadSiteImages();

        $this->newLine();
        $this->info('✅  All done!');
        return self::SUCCESS;
    }

    // ─── Blog posts ───────────────────────────────────────────────────────────

    private function downloadBlogImages(): void
    {
        $this->info('📝  Blog posts...');

        $seeds = [
            'frecuencia-examen-visual'      => 'optical-exam',
            'miopia-ninos-senales-alerta'   => 'myopia-child',
            'sindrome-vision-computadora'   => 'computer-screen',
            'glaucoma-silencioso'           => 'eye-health',
            'alimentacion-salud-visual'     => 'healthy-food',
            'cataratas-preguntas-frecuentes'=> 'senior-eye',
            'mitos-lentes-contacto'         => 'contact-lens',
            'ojo-seco-causas-remedios'      => 'dry-eye',
            'como-elegir-monturas-perfectas'=> 'glasses-fashion',
            'proteccion-solar-ojos-uv'      => 'sunglasses-uv',
            'terapia-visual-que-es'         => 'vision-therapy',
            'lentes-progresivos-guia'       => 'progressive-lens',
        ];

        $posts = BlogPost::all()->keyBy('slug');

        foreach ($seeds as $slug => $seed) {
            $post = $posts->get($slug);
            if (!$post) {
                $this->warn("  ↷ Post not found: {$slug}");
                continue;
            }

            $path = "blog/post-{$post->id}.jpg";

            if (!$this->option('force') && $post->image && Storage::disk('public')->exists($post->image)) {
                $this->line("  ↷ Skip (exists): {$slug}");
                continue;
            }

            if ($this->download($this->picsum($seed, 1200, 630), "public/{$path}")) {
                $post->update(['image' => $path]);
                $this->line("  ✓ {$slug}");
            } else {
                $this->warn("  ✗ Failed: {$slug}");
            }
        }
    }

    // ─── Services ─────────────────────────────────────────────────────────────

    private function downloadServiceImages(): void
    {
        $this->info('🔧  Services...');

        $seeds = [
            'examen-visual-integral'             => 'eye-exam-clinic',
            'contactologia-lentes-contacto'      => 'contact-lenses',
            'terapia-visual'                     => 'vision-therapy-child',
            'control-visual-infantil'            => 'child-eye-doctor',
            'asesoria-monturas'                  => 'eyewear-frames',
            'lentes-oftalmicos'                  => 'ophthalmic-lens',
            'gafas-sol-uv'                       => 'sunglasses-outdoor',
            'control-miopia-infantil'            => 'myopia-control',
            'baja-vision'                        => 'low-vision-aid',
            'examen-visual-conducir'             => 'driving-vision',
            'reparacion-gafas'                   => 'glasses-repair',
            'nutricion-salud-ocular'             => 'nutrition-health',
        ];

        $services = Service::all()->keyBy('slug');

        foreach ($seeds as $slug => $seed) {
            $service = $services->get($slug);
            if (!$service) {
                $this->warn("  ↷ Service not found: {$slug}");
                continue;
            }

            $path = "services/service-{$service->id}.jpg";

            if (!$this->option('force') && $service->image && Storage::disk('public')->exists($service->image)) {
                $this->line("  ↷ Skip (exists): {$slug}");
                continue;
            }

            if ($this->download($this->picsum($seed, 800, 600), "public/{$path}")) {
                $service->update(['image' => $path]);
                $this->line("  ✓ {$slug}");
            } else {
                $this->warn("  ✗ Failed: {$slug}");
            }
        }
    }

    // ─── Categories ───────────────────────────────────────────────────────────

    private function downloadCategoryImages(): void
    {
        $this->info('📁  Categories...');

        $seeds = [
            'lentes-hombre'     => 'men-glasses-fashion',
            'lentes-mujer'      => 'women-glasses-fashion',
            'lentes-infantiles' => 'children-glasses',
            'gafas-sol'         => 'sunglasses-display',
            'lentes-deportivos' => 'sport-sunglasses',
            'lentes-contacto'   => 'contact-lens-solution',
        ];

        $categories = Category::all()->keyBy('slug');

        foreach ($seeds as $slug => $seed) {
            $category = $categories->get($slug);
            if (!$category) {
                $this->warn("  ↷ Category not found: {$slug}");
                continue;
            }

            $path = "categories/cat-{$category->id}.jpg";

            if (!$this->option('force') && $category->image && Storage::disk('public')->exists($category->image)) {
                $this->line("  ↷ Skip (exists): {$slug}");
                continue;
            }

            if ($this->download($this->picsum($seed, 800, 600), "public/{$path}")) {
                $category->update(['image' => $path]);
                $this->line("  ✓ {$slug}");
            } else {
                $this->warn("  ✗ Failed: {$slug}");
            }
        }
    }

    // ─── Brand logos ──────────────────────────────────────────────────────────

    private function downloadBrandLogos(): void
    {
        $this->info('🏷️   Brand logos...');

        $domains = [
            'ray-ban'                    => 'ray-ban.com',
            'adidas'                     => 'adidas.com',
            'puma'                       => 'puma.com',
            'guess'                      => 'guess.com',
            'tommy-hilfiger'             => 'tommy.com',
            'ralph-lauren'               => 'ralphlauren.com',
            'calvin-klein'               => 'calvinklein.com',
            'swarovski'                  => 'swarovski.com',
            'h-m'                        => 'hm.com',
            'champion'                   => 'champion.com',
            'vogue-eyewear'              => 'vogue-eyewear.com',
            'timberland'                 => 'timberland.com',
            'columbia-eyewear'           => 'columbia.com',
            'kenneth-cole-reaction'      => 'kennethcole.com',
            'converse'                   => 'converse.com',
            'nano-vista'                 => 'nanovista.es',
            'united-colors-of-benetton'  => 'benetton.com',
        ];

        $brands = Brand::all()->keyBy('slug');

        foreach ($domains as $slug => $domain) {
            $brand = $brands->get($slug);
            if (!$brand) {
                continue;
            }

            $path = "brands/logo-{$brand->id}.png";

            if (!$this->option('force') && $brand->logo && Storage::disk('public')->exists($brand->logo)) {
                $this->line("  ↷ Skip (exists): {$slug}");
                continue;
            }

            $url = str_replace('{domain}', $domain, self::CLEARBIT);

            if ($this->download($url, "public/{$path}")) {
                $brand->update(['logo' => $path]);
                $this->line("  ✓ {$slug}");
            } else {
                // Clearbit failed — generate a simple text-based SVG placeholder
                $svgPath = "brands/logo-{$brand->id}.svg";
                $svg = $this->makeSvgLogo($brand->name);
                Storage::disk('public')->put($svgPath, $svg);
                $brand->update(['logo' => $svgPath]);
                $this->line("  ~ {$slug} (SVG placeholder)");
            }
        }
    }

    // ─── Site-wide images (hero, about) ──────────────────────────────────────

    private function downloadSiteImages(): void
    {
        $this->info('🎨  Site images (hero, about)...');

        $images = [
            'hero_image'  => ['seed' => 'optical-store-interior', 'w' => 900, 'h' => 700, 'dir' => 'pages/hero.jpg'],
            'about_image' => ['seed' => 'optician-professional',  'w' => 800, 'h' => 600, 'dir' => 'pages/about.jpg'],
        ];

        foreach ($images as $key => $cfg) {
            $existing = SiteSetting::get($key, '');

            if (!$this->option('force') && $existing && Storage::disk('public')->exists($existing)) {
                $this->line("  ↷ Skip (exists): {$key}");
                continue;
            }

            $path = $cfg['dir'];

            if ($this->download($this->picsum($cfg['seed'], $cfg['w'], $cfg['h']), "public/{$path}")) {
                SiteSetting::updateOrCreate(['key' => $key], ['value' => $path]);
                SiteSetting::flushCache();
                $this->line("  ✓ {$key}");
            } else {
                $this->warn("  ✗ Failed: {$key}");
            }
        }
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function picsum(string $seed, int $w, int $h): string
    {
        return str_replace(['{seed}', '{w}', '{h}'], [$seed, $w, $h], self::PICSUM);
    }

    private function download(string $url, string $storagePath): bool
    {
        try {
            $response = Http::timeout(30)->withOptions(['allow_redirects' => true])->get($url);

            if ($response->successful() && strlen($response->body()) > 1000) {
                Storage::put($storagePath, $response->body());
                return true;
            }
        } catch (\Throwable $e) {
            $this->warn("    HTTP error for {$url}: " . $e->getMessage());
        }
        return false;
    }

    private function makeSvgLogo(string $name): string
    {
        $initials = mb_strtoupper(mb_substr($name, 0, 2));
        $colors   = ['#284f8d', '#1a6b5a', '#7c3aed', '#b45309', '#1d4ed8'];
        $color    = $colors[crc32($name) % count($colors)];

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="200" height="80" viewBox="0 0 200 80">
  <rect width="200" height="80" rx="8" fill="{$color}"/>
  <text x="100" y="28" font-family="Arial,sans-serif" font-size="11" font-weight="bold"
        fill="white" text-anchor="middle" dominant-baseline="middle">{$initials}</text>
  <text x="100" y="52" font-family="Arial,sans-serif" font-size="10" fill="rgba(255,255,255,0.85)"
        text-anchor="middle" dominant-baseline="middle">{$name}</text>
</svg>
SVG;
    }
}
