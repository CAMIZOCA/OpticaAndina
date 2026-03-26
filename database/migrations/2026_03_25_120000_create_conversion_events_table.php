<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversion_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('event_category')->nullable();
            $table->string('page_path', 500)->nullable()->index();
            $table->text('page_url')->nullable();
            $table->string('route_name')->nullable()->index();
            $table->string('session_token', 100)->nullable()->index();
            $table->string('source', 100)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('referrer')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['event_name', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversion_events');
    }
};
