<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalonDpdRiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calon_dpd_ris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_calon_dpd');
            $table->foreignId('tahun_pemilihan_id')->constrained('tahun_pemilihans')->onDelete('cascade');
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
        Schema::dropIfExists('calon_dpd_ris');
    }
}
