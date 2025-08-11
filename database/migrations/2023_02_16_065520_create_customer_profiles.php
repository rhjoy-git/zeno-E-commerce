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
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->id();

            $table->string('cus_name', 100);
            $table->string('cus_address', 500);
            $table->string('cus_city', 50);
            $table->string('cus_state', 50)->nullable();
            $table->string('cus_postcode', 50)->nullable();
            $table->string('cus_country', 50)->nullable();
            $table->string('cus_phone', 50)->nullable();
            $table->string('cus_fax', 50)->nullable();

            $table->unsignedInteger('entry_user_id')->nullable();
            $table->unsignedBigInteger('user_id')->unique();

            $table->foreign('user_id')->references('id')->on('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });

        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_name', 100);
            $table->string('address_line1', 255);
            $table->string('address_line2', 255)->nullable();
            $table->string('city', 100);
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20);
            $table->string('country', 100);
            $table->string('phone', 50);
            $table->string('email', 100)->nullable();

            $table->string('company_name', 100)->nullable();
            $table->text('delivery_instructions')->nullable();
            $table->boolean('is_default')->default(false);

            // Relationships
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Indexes
            $table->index('user_id');
            $table->index(['user_id', 'is_default']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_profiles');
    }
};
