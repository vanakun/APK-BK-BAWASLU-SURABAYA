<?php

namespace App\Models;

use App\Models\PresidenWakilPresiden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'aduan_id',
        'aduan_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function presidenWakilPresiden()
    {
        return $this->belongsTo(PresidenWakilPresiden::class, 'aduan_id');
    }

    public function aduan()
    {
        // Tambahkan 'aduan_type' sebagai parameter kedua untuk menentukan jenis polymorphic relationship
        return $this->morphTo();
    }
}
