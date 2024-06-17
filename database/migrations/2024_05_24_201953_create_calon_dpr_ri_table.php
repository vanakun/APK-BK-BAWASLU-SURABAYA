<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalonDprRiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('calon_dpr_ri', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->foreignId('partai_id')->constrained('partais')->onDelete('cascade');
        $table->foreignId('tahun_pemilihan_id')->constrained('tahun_pemilihans')->onDelete('cascade');
        // tambahkan kolom lain sesuai kebutuhan, seperti kolom foto, dll
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
        Schema::dropIfExists('calon_dpr_ri');
    }
}