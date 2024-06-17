<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanDpdRi extends Model
{
    use HasFactory;

    protected $table = 'aduan_dpd_ri';

    protected $fillable = [
        'status', 
        'jenis_atribut', 
        'jenis_pemilihan', 
        'nama_calon_dpd', 
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


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tahunPemilihan()
    {
        return $this->belongsTo(TahunPemilihan::class, 'tahun_pemilihan_id');
    }
}
