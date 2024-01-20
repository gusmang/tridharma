<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('acara_id');
            $table->bigInteger('jadwal_id')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('nama');
            $table->tinyInteger('jumlah_peserta')->default(1);
            $table->text('list_peserta')->nullable();
            $table->string('alamat');
            $table->string('penanggung_jawab');
            $table->string('telpon');
            $table->text('catatan')->nullable();
            $table->boolean('sudah_bayar')->default(false);
            $table->integer('punia');
            $table->tinyInteger('nomor_urut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesertas');
    }
};
