<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_requests', function (Blueprint $table) {
            $table->decimal('price_per_item', 15, 2)->nullable()->after('order_quantity');
            $table->integer('confirmed_order_quantity')->nullable()->after('price_per_item');
        });
    }

    public function down(): void
    {
        Schema::table('order_requests', function (Blueprint $table) {
            $table->dropColumn(['price_per_item', 'confirmed_order_quantity']);
        });
    }
};