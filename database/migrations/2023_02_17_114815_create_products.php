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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('short_des', 500)->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->boolean('discount')->default(false);
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->integer('stock_alert')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('slug')->unique();
            $table->string('sku', 50)->unique();
            $table->enum('status', ['active', 'inactive', 'discontinued'])->default('active')->index();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete()->cascadeOnUpdate();
            $table->index('category_id');
            $table->index('brand_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('tag', 50)->nullable(); // e.g., 'popular', 'new', 'trending'
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tags');
        Schema::dropIfExists('products');
    }
};
