<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partais', function (Blueprint $table) {
            $table->id(); // Primary key dengan nama partai_id
            $table->string('nama_partai'); // Nama partai
            $table->foreignId('tahun_pemilihan_id')->constrained('tahun_pemilihans')->onDelete('cascade');
            $table->timestamps(); // Menambahkan created_at dan updated_at kolom
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partais');
    }
}
