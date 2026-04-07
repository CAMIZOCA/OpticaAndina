<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConversionEventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');

Route::get('/servicios', [ServiceController::class, 'index'])->name('servicios');
Route::get('/servicios/{slug}', [ServiceController::class, 'show'])->name('servicios.show');

Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalogo');
Route::get('/catalogo/{category}', [CatalogController::class, 'category'])->name('catalogo.categoria');
Route::get('/catalogo/{category}/{product}', [CatalogController::class, 'product'])->name('catalogo.producto');

Route::get('/marcas', [BrandController::class, 'index'])->name('marcas');
Route::get('/marcas/{slug}', [BrandController::class, 'show'])->name('marcas.show');

Route::get('/galeria', [MediaController::class, 'index'])->name('galeria');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/contacto', [ContactController::class, 'index'])->name('contacto');
Route::post('/contacto', [ContactController::class, 'store'])->name('contacto.store')->middleware('throttle:5,1');
Route::post('/conversion-events', [ConversionEventController::class, 'store'])->name('conversion-events.store')->middleware('throttle:120,1');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemaps/pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemaps/services.xml', [SitemapController::class, 'services'])->name('sitemap.services');
Route::get('/sitemaps/categories.xml', [SitemapController::class, 'categories'])->name('sitemap.categories');
Route::get('/sitemaps/products.xml', [SitemapController::class, 'products'])->name('sitemap.products');
Route::get('/sitemaps/brands.xml', [SitemapController::class, 'brands'])->name('sitemap.brands');
Route::get('/sitemaps/articles.xml', [SitemapController::class, 'articles'])->name('sitemap.articles');
Route::get('/sitemaps/images.xml', [SitemapController::class, 'images'])->name('sitemap.images');
Route::get('/robots.txt', RobotsController::class)->name('robots');

Route::get('/checkout/success', [StripeController::class, 'success'])->name('checkout.success');
Route::post('/checkout/{product:slug}', [StripeController::class, 'checkout'])->name('checkout');
