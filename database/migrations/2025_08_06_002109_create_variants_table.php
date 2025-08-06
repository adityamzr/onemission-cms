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
        Schema::create('variants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('outfit_id')->nullable();
            $table->foreign('outfit_id')->references('id')->on('outfits');
            $table->string('slug');
            $table->string('color');
            $table->string('color_code');
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('in_stock')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
