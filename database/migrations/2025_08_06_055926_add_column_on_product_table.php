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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('us_status')->after('usage')->default(false);
            $table->boolean('tec_status')->after('technology')->default(false);
            $table->boolean('ft_status')->after('features')->default(false);
            $table->boolean('com_status')->after('composition')->default(false);
            $table->boolean('sus_status')->after('sustainable')->default(false);
            $table->boolean('war_status')->after('warranty')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('us_status');
            $table->dropColumn('tec_status');
            $table->dropColumn('ft_status');
            $table->dropColumn('com_status');
            $table->dropColumn('sus_status');
            $table->dropColumn('war_status');
        });
    }
};
