<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
           // $table->string('verifikasi_token')->nullable();
            //$table->boolean('verifikasi_email')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn(['verifikasi_token', 'verifikasi_email']);
        });
    }
};
