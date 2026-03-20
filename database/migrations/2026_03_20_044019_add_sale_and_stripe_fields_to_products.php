<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_on_sale')->default(false)->after('is_featured');
            $table->decimal('price', 10, 2)->nullable()->after('is_on_sale');
            $table->boolean('is_purchasable')->default(false)->after('price');
            $table->string('stripe_price_id')->nullable()->after('is_purchasable');

            $table->index('is_on_sale', 'idx_products_on_sale');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_on_sale');
            $table->dropColumn(['is_on_sale', 'price', 'is_purchasable', 'stripe_price_id']);
        });
    }
};
