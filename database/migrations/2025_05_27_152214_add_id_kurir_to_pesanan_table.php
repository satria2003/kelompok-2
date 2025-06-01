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
    Schema::table('pesanan', function (Blueprint $table) {
        $table->unsignedBigInteger('id_kurir')->nullable()->after('id_pengguna');

        // (Opsional) jika kamu ingin relasi foreign key:
        // $table->foreign('id_kurir')->references('id')->on('kurirs')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('pesanan', function (Blueprint $table) {
        $table->dropColumn('id_kurir');
    });
}

};
