<?php

namespace App\Models;

use App\Models\TahunPemilihan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonDpdRi extends Model
{

    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_calon_dpd',
        'tahun_pemilihan_id',
    ];

    public function tahunPemilihan()
    {
        return $this->belongsTo(TahunPemilihan::class, 'tahun_pemilihan_id');
    }
}
