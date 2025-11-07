<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Fuel information
            $table->string('fuel_type')->nullable()->after('total_amount');
            
            // Location information
            $table->string('delivery_address')->nullable()->after('fuel_type');
            
            // Vehicle information
            $table->string('license_plate')->nullable()->after('delivery_address');
            $table->string('vehicle_type')->nullable()->after('license_plate');
            $table->string('vehicle_make')->nullable()->after('vehicle_type');
            $table->string('vehicle_model')->nullable()->after('vehicle_make');
            $table->string('vehicle_color')->nullable()->after('vehicle_model');
            
            // Payment information
            $table->string('payment_method')->nullable()->after('vehicle_color');
            $table->string('payment_ref_number')->nullable()->after('payment_method');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'fuel_type',
                'delivery_address',
                'license_plate',
                'vehicle_type',
                'vehicle_make',
                'vehicle_model',
                'vehicle_color',
                'payment_method',
                'payment_ref_number',
            ]);
        });
    }
};

