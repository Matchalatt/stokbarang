<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // User sales yang membuat request
            $table->string('item_name');
            $table->integer('current_stock');
            $table->integer('required_stock');
            $table->integer('order_quantity');
            $table->enum('status', ['pending', 'processed', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_requests');
    }
};