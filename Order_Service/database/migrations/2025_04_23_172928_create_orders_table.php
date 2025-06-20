<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->decimal('total_price', 10, 2);
        $table->enum('status', ['pending', 'paid'])->default('pending');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('orders');
}

};
