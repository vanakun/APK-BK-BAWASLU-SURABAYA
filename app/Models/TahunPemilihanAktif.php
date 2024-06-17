<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPemilihanAktif extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model name
    protected $table = 'tahun_pemilihan_aktif';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id';

    // Specify which attributes are mass assignable
    protected $fillable = ['tahun_pemilihan_aktif'];
}

