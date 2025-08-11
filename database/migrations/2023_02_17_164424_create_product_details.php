<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->longText('description')->nullable();
            $table->text('specifications')->nullable();
            $table->string('warranty')->nullable();
            $table->unsignedBigInteger('product_id')->unique();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('color', 50)->nullable();
            $table->string('hex_code')->nullable();
            $table->string('size', 50)->nullable();
            $table->integer('stock_alert')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->string('sku', 100)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->unique(['product_id', 'color', 'size']);
            $table->timestamps();
        });
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->string('image_path', 255);
            $table->boolean('is_primary')->default(false);
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('variant_id')->references('id')->on('product_variants')->nullOnDelete();
            $table->index('product_id');
            $table->index('variant_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');   
        Schema::dropIfExists('product_variants'); 
        Schema::dropIfExists('product_details'); 
    }
};
