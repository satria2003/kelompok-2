<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->string('username')->unique();
            $table->string('nama_lengkap')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('foto_profil')->nullable();
            $table->string('peran')->default('pelanggan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
