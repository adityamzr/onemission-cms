<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image');
            $table->decimal('price', 10, 2);
            $table->decimal('originalPrice', 10, 2);
            $table->boolean('is_active')->default(false);
            $table->string('usage')->nullable();
            $table->string('technology')->nullable();
            $table->text('features')->nullable();
            $table->string('composition')->nullable();
            $table->string('sustainability')->nullable();
            $table->string('warranty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
