<?php

namespace App\Models;

use App\Models\TahunPemilihan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonDprRi extends Model
{
    use HasFactory;

    protected $table = 'calon_dpr_ri';

    protected $fillable = [
        'nama',
        'partai_id',
        'tahun_pemilihan_id',
        // add other columns you need here
    ];

    public function partai()
    {
        return $this->belongsTo(Partai::class);
    }

    public function tahunPemilihan()
    {
        return $this->belongsTo(TahunPemilihan::class, 'tahun_pemilihan_id');
    }
}
