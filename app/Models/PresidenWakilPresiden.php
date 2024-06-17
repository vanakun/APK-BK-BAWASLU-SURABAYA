<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresidenWakilPresiden extends Model
{
    use HasFactory;

    protected $table = 'presiden_wakil_presiden';
    protected $primaryKey = 'id'; // Jika nama kolom primary key-nya tidak 'id', sesuaikan di sini
    protected $fillable = [
        'nama_presiden',
        'nama_wakil',
        'tahun_pemilihan_id',
    ];

    public function tahunPemilihan()
{
    return $this->belongsTo(TahunPemilihan::class, 'tahun_pemilihan_id');
}

    


}
