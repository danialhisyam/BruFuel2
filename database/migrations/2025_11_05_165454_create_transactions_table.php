<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trip_id')->nullable();
            $table->string('type')->default('trip');
            $table->decimal('amount', 8, 2)->default(0);
            $table->enum('status', ['completed', 'pending', 'cancelled']);
            $table->timestamp('transaction_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
