<?php

// app/Models/CalonDprdKota.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonDprdKota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_calon_dprd_kota',
        'partai_id',
        'tahun_pemilihan_id',
        'dapil',
    ];

    public function partai()
    {
        return $this->belongsTo(Partai::class);
    }

    public function tahunPemilihan()
    {
        return $this->belongsTo(TahunPemilihan::class);
    }
}
