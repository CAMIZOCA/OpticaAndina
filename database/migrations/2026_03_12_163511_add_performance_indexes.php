<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add performance indexes to frequently queried columns.
     */
    public function up(): void
    {
        // products: lookups by slug, category, brand, availability, featured
        Schema::table('products', function (Blueprint $table) {
            $table->index('is_available',  'idx_products_is_available');
            $table->index('is_featured',   'idx_products_is_featured');
            $table->index(['category_id', 'is_available'], 'idx_products_cat_available');
            $table->index(['brand_id',    'is_available'], 'idx_products_brand_available');
            // Full-text index on name for LIKE searches in ProductFilter
            $table->fullText('name', 'ft_products_name');
        });

        // categories: lookups by slug and active state
        Schema::table('categories', function (Blueprint $table) {
            $table->index('is_active',           'idx_categories_active');
            $table->index(['parent_id', 'is_active'], 'idx_categories_parent_active');
        });

        // blog_posts: published listing queries
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->index(['is_published', 'published_at'], 'idx_posts_published_at');
        });

        // services: active lookup
        Schema::table('services', function (Blueprint $table) {
            $table->index('is_active', 'idx_services_active');
        });

        // brands: active listing
        Schema::table('brands', function (Blueprint $table) {
            $table->index('is_active', 'idx_brands_active');
        });

        // redirects: path lookup on every request
        Schema::table('redirects', function (Blueprint $table) {
            $table->index(['from_path', 'is_active'], 'idx_redirects_path_active');
        });
    }

    /**
     * Drop the added indexes.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_is_available');
            $table->dropIndex('idx_products_is_featured');
            $table->dropIndex('idx_products_cat_available');
            $table->dropIndex('idx_products_brand_available');
            $table->dropFullText('ft_products_name');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_active');
            $table->dropIndex('idx_categories_parent_active');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex('idx_posts_published_at');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex('idx_services_active');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropIndex('idx_brands_active');
        });

        Schema::table('redirects', function (Blueprint $table) {
            $table->dropIndex('idx_redirects_path_active');
        });
    }
};
