<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partai extends Model
{
    use HasFactory;

    protected $table = 'partais';
    protected $primaryKey = 'id';
    protected $fillable = ['partai_id','nama_partai','tahun_pemilihan_id'];

    public function tahunPemilihan()
    {
        return $this->belongsTo(TahunPemilihan::class, 'tahun_pemilihan_id');
    }
}

