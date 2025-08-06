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
        Schema::create('variant_sizes', function (Blueprint $table) {
            $table->id();
            $table->uuid('variant_id');
            $table->foreign('variant_id')->references('id')->on('variants');
            $table->string('size');
            $table->integer('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_sizes');
    }
};
