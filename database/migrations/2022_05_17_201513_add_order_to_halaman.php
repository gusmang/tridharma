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
        Schema::table('halaman', function (Blueprint $table) {
            $table->tinyInteger('order')->default(0);
            $table->boolean('is_homepage')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('halaman', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->dropColumn('is_homepage');
        });
    }
};
