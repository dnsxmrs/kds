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
        //
        // add enum 'delivery' to the orders status column
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('order_status', ['pending', 'preparing', 'ready', 'delivery', 'completed', 'cancelled'])
                    ->default('pending')  // Set 'pending' as the default value
                    ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('order_status  ', ['pending', 'preparing', 'ready', 'completed', 'cancelled'])
                    ->default('pending')  // Set 'pending' as the default value
                    ->change();
        });
    }
};
