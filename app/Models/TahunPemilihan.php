<?php
namespace App\Models;

use App\Models\CalonDpdRi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPemilihan extends Model
{
    use HasFactory;

    protected $table = 'tahun_pemilihans';

    protected $fillable = [
        'tahun_pemilihans',
        'tahun_pemilihan_id',
    ];

   


}