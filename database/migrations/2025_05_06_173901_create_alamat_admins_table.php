<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('alamat_admins', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengirim');
            $table->string('no_telepon');
            $table->text('alamat_lengkap');
            $table->unsignedBigInteger('provinsi_id');
            $table->string('kodepos')->nullable();
            $table->integer('ongkir')->default(50000); // tarif per 5km
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat_admins');
    }
};
