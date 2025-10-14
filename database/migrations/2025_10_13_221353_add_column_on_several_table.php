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
        Schema::table('orders', function (Blueprint $table) {
            $table->datetime('expires_at')->after('cancel_reason')->nullable();
        });
        Schema::table('variant_sizes', function (Blueprint $table) {
            $table->integer('reserved_stock')->after('stock')->nullable();
            $table->timestamps()->after('reserved_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });
        Schema::table('variant_sizes', function (Blueprint $table) {
            $table->dropColumn(['reserved_stock', 'created_at', 'updated_at']);
        });
    }
};
