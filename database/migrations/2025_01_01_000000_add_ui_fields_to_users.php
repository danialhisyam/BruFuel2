<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_ui_fields_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $t) {
            if (!Schema::hasColumn('users','external_id'))   $t->string('external_id')->nullable()->index();
            if (!Schema::hasColumn('users','status'))        $t->enum('status', ['Active','Inactive','Pending'])->default('Active');
            if (!Schema::hasColumn('users','last_login_at')) $t->timestamp('last_login_at')->nullable();
            if (!Schema::hasColumn('users','avatar'))        $t->string('avatar')->nullable();
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['external_id','status','last_login_at','avatar']);
        });
    }
};
