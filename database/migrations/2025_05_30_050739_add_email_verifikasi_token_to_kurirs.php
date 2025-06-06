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
        Schema::table('kurirs', function (Blueprint $table) {
            $table->string('email_verifikasi_token', 100)->nullable()->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kurirs', function (Blueprint $table) {
            $table->dropColumn('email_verifikasi_token');
        });
    }
};
