<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKendaraansTable extends Migration
{
    public function up()
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor');
            $table->string('jenis');
            $table->string('merk');
            $table->unsignedBigInteger('kurir_id')->nullable();
            $table->timestamps();

            $table->foreign('kurir_id')->references('id')->on('kurirs')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kendaraans');
    }
}
