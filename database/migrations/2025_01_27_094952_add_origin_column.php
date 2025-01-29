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
        // add origin column to orders
        Schema::table('orders', function (Blueprint $table) {
            $table->string('origin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // remove the added column
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('origin');
        });
    }
};
