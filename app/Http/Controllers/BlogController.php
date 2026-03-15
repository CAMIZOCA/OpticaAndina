<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Services\SeoService;

class BlogController extends Controller
{
    public function index()
    {
        $seo   = SeoService::forPage('blog');
        $posts = BlogPost::published()->latest()->paginate(9);
        return view('pages.blog.index', compact('seo', 'posts'));
    }

    public function show(string $slug)
    {
        $post    = BlogPost::where('slug', $slug)->published()->firstOrFail();
        $seo     = SeoService::forBlogPost($post);
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Blog', 'url' => route('blog')],
            ['name' => $post->title],
        ]);
        $related = BlogPost::published()->where('id', '!=', $post->id)->latest()->limit(3)->get();
        return view('pages.blog.post', compact('seo', 'post', 'related'));
    }
}
