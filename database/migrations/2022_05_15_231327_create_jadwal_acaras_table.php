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
        Schema::create('jadwal_acaras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('acara_id');
            $table->date('tanggal');
            $table->string('dinan');
            $table->tinyInteger('jumlah_peserta');
            $table->text('penjelasan')->nullable();
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
        Schema::dropIfExists('jadwal_acaras');
    }
};
