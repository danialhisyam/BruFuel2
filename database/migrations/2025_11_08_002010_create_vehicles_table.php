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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            // 🔗 Relation to user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 🚗 Vehicle details
            $table->string('license_plate');
            $table->string('vehicle_type');
            $table->string('make');
            $table->string('model');
            $table->string('color');

            // 🖼 Optional image upload
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
