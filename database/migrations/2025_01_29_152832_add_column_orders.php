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
        // add colymn in orders , a column for order_id
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_id'); // External reference ID for Web/POS
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
};
