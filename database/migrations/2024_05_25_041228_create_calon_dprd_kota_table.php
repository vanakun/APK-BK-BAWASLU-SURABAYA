<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalonDprdKotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calon_dprd_kotas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_calon_dprd_kota');
            $table->foreignId('partai_id')->constrained('partais')->onDelete('cascade');
            $table->foreignId('tahun_pemilihan_id')->constrained('tahun_pemilihans')->onDelete('cascade');
            $table->string('dapil')->nullable();
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
        Schema::dropIfExists('calon_dprd_kotas');
    }
}
