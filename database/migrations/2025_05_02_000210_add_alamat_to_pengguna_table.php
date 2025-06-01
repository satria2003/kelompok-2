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
        if (!Schema::hasColumn('pengguna', 'alamat')) {
            Schema::table('pengguna', function (Blueprint $table) {
                $table->string('alamat')->nullable()->after('password');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('pengguna', 'alamat')) {
            Schema::table('pengguna', function (Blueprint $table) {
                $table->dropColumn('alamat');
            });
        }
    }
};