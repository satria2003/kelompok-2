<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kurirs', function (Blueprint $table) {
            $table->string('token_login')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('kurirs', function (Blueprint $table) {
            $table->dropColumn('token_login');
        });
    }
};
