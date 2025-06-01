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
        Schema::table('pengguna', function (Blueprint $table) {
            if (!Schema::hasColumn('pengguna', 'token_verifikasi')) {
                $table->string('token_verifikasi')->nullable()->after('foto_profil');
            }
            if (!Schema::hasColumn('pengguna', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('token_verifikasi');
            }
            if (!Schema::hasColumn('pengguna', 'verifikasi_email')) {
                $table->boolean('verifikasi_email')->default(false)->after('email_verified_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn(['token_verifikasi', 'email_verified_at', 'verifikasi_email']);
        });
    }
};
