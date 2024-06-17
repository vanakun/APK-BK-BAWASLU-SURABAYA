<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAduanLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aduan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('aduan_id');
            $table->string('aduan_type');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Optional: Jika aduan_id adalah foreign key dari tabel tertentu
            // $table->foreign('aduan_id')->references('id')->on('nama_tabel_aduan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('aduan_logs');
    }
}
