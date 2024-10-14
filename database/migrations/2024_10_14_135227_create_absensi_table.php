<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); // relasi dengan tabel users
            $table->string('location'); // lokasi absensi (latitude, longitude)
            $table->string('photo'); // path untuk foto absensi
            $table->string('type'); // tipe absensi (masuk atau keluar)
            $table->string('verivikasi'); 
            $table->string('verivikasi_oleh'); 
            $table->timestamps(); // untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi');
    }
}
