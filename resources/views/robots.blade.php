User-agent: *
Allow: /

Disallow: /admin
Disallow: /admin/*

Sitemap: {{ rtrim(config('app.url'), '/') }}/sitemap.xml
