<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanPresidenWakilPresiden extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 
        'jenis_atribut', 
        'jenis_pemilihan', 
        'nama_calon', 
        'lokasi_pemasangan', 
        'nama_jalan',
        'tanggal_laporan', 
        'tanggal_akhir_ditertibkan', 
        'keterangan', 
        'tanggal_penertiban', 
        'jenis_penertiban', 
        'gambar_sebelum', 
        'gambar_sesudah',
        'tahun_pemilihan_id',
        'user_id',
    ];

    public function tahunPemilihan()
    {
        return $this->belongsTo(TahunPemilihan::class, 'tahun_pemilihan_id');
    }

    public function aduan()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
