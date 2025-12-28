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
        Schema::create('cart_action', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('product_id');
            $table->string('action')->nullable();
            $table->integer('quantity')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('cart_action', function (Blueprint $table) {
            $table->foreign('cart_id')
                ->references('id')
                ->on('cart')
                ->onDelete('cascade');
        });

        Schema::table('cart_action', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_action');
    }
};
