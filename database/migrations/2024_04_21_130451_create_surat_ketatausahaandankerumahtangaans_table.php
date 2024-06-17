<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratKetatausahaandankerumahtangaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_ketatausahaan_dan_kerumahtangaans', function (Blueprint $table) {
            $table->id();
            $table->string('j_surat')->default('Keuangan (KU)');
            $table->date('tanggal');
            $table->string('nama');
            $table->string('perihal');
            $table->string('tujuan');
            $table->string('jenis_surat');
            $table->text('keterangan')->nullable();
            $table->string('kota');
            $table->string('fasilitatif')->nullable();
            $table->string('no_surat')->nullable();
            $table->string('file_surat')->nullable(); // Kolom untuk menyimpan nama file surat, dapat bernilai null
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('status', ['queue','proces', 'done'])->default('queue');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('surat_ketatausahaan_dan_kerumahtangaans');
    }
}
