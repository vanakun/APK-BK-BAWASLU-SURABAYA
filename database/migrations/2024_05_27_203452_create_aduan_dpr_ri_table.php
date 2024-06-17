<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAduanDprRiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aduan_dpr_ri', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['queue', 'proces', 'done'])->default('queue');
            $table->string('jenis_atribut');
            $table->string('jenis_pemilihan')->default('DPR-RI');
            $table->string('nama');
            $table->string('nama_partai'); // Kolom untuk menyimpan nama partai
            $table->string('lokasi_pemasangan');
            $table->string('nama_jalan')->nullable(); // Kolom untuk menyimpan nama jalan
            $table->date('tanggal_laporan');
            $table->date('tanggal_akhir_ditertibkan')->nullable();
            $table->enum('keterangan', ['belum di tertibkan', 'terlambat', 'sudah di tertibkan'])->default('belum di tertibkan');
            $table->date('tanggal_penertiban')->nullable();
            $table->string('jenis_penertiban')->nullable();
            $table->string('gambar_sebelum')->nullable();
            $table->string('gambar_sesudah')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('tahun_pemilihan_id');
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
        Schema::dropIfExists('aduan_dpr_ri');
    }
}
