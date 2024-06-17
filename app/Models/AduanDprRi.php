<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanDprRi extends Model
{
    use HasFactory;

    protected $table = 'aduan_dpr_ri';

    protected $fillable = [
        'status', 
        'jenis_atribut', 
        'jenis_pemilihan', 
        'nama',
        'nama_partai', // Kolom untuk menyimpan nama partai
        'lokasi_pemasangan', 
        'nama_jalan',
        'tanggal_laporan', 
        'tanggal_akhir_ditertibkan', 
        'keterangan', 
        'tanggal_penertiban', 
        'jenis_penertiban', 
        'gambar_sebelum', 
        'gambar_sesudah',
        'user_id',
        'tahun_pemilihan_id',
    ];

    public function partai()
    {
        return $this->belongsTo(Partai::class,'nama_partai');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tahunPemilihan()
    {
        return $this->belongsTo(TahunPemilihan::class, 'tahun_pemilihan_id');
    }
}
