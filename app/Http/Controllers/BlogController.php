<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Services\SeoService;
use App\Support\MediaUrl;

class BlogController extends Controller
{
    public function index()
    {
        $seo = SeoService::forPage('blog');
        $posts = BlogPost::published()->latest()->paginate(9);

        $seo['schema'] = SeoService::collectionPageSchema(
            'Blog',
            route('blog'),
            $posts->getCollection()->map(fn (BlogPost $post) => [
                'name' => $post->title,
                'url' => route('blog.show', $post->slug),
                'image' => MediaUrl::image($post->image),
            ])->all(),
            'Articulos y consejos sobre salud visual en Tumbaco.'
        );
        $seo = SeoService::applyDefaults($seo);

        return view('pages.blog.index', compact('seo', 'posts'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::where('slug', $slug)->published()->firstOrFail();
        $seo = SeoService::forBlogPost($post);
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Blog', 'url' => route('blog')],
            ['name' => $post->title],
        ]);
        $seo = SeoService::applyDefaults($seo);

        $related = BlogPost::published()->where('id', '!=', $post->id)->latest()->limit(3)->get();

        return view('pages.blog.post', compact('seo', 'post', 'related'));
    }
}
