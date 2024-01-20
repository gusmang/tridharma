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
        Schema::create('acaras', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->tinyInteger('order')->default(0);
            $table->mediumText('penjelasan');
            $table->mediumText('yang_di_dapat');
            $table->mediumText('yang_di_bawa');
            $table->mediumText('susunan_acara');
            $table->enum('sistem_jadwal',['Setiap Hari','Terjadwal']);
            $table->enum('sistem_kepesertaan',['Satu Orang','Lebih Dari satu orang']);
            $table->integer('punia');
            $table->datetime('deleted_at')->nullable();
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
        Schema::dropIfExists('acaras');
    }
};
