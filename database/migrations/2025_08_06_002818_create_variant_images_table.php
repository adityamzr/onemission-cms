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
        Schema::create('variant_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('variant_id');
            $table->foreign('variant_id')->references('id')->on('variants');
            $table->text('image_url');
            $table->boolean('is_primary')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_images');
    }
};
