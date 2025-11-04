<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // this will be your order ID on the page
            $table->string('customer_name');     // e.g. ADIB, ALYA, etc.
            $table->enum('provider', ['BIBD', 'BAIDURI', 'TAB', 'CASH']);
            $table->enum('status', ['Paid', 'Pending', 'Fail'])->index();
            $table->decimal('amount', 10, 2);    // BND with 2 decimals
            $table->dateTime('paid_at')->index();// the "date" you show on UI
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('payments');
    }
};
