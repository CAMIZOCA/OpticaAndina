<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
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

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/contacto', [ContactController::class, 'index'])->name('contacto');
Route::post('/contacto', [ContactController::class, 'store'])->name('contacto.store');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
