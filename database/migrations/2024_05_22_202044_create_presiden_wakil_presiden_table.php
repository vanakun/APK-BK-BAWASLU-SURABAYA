<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresidenWakilPresidenTable extends Migration
{
    public function up()
    {
        Schema::create('presiden_wakil_presiden', function (Blueprint $table) {
            $table->id();
            $table->string('nama_presiden');
            $table->string('nama_wakil');
            $table->foreignId('tahun_pemilihan_id')->constrained('tahun_pemilihans')->onDelete('cascade');
            // Tambahkan kolom lain yang mungkin Anda perlukan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('presiden_wakil_presiden');
    }
}

