<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiM extends Model
{
    use HasFactory;

    // Tentukan nama tabel
    protected $table = 'absensi';

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'user_id', 
        'location', 
        'photo', 
        'type',
        'verifikasi',
        'confirmation',
        'verifikasi_oleh',
    ];

    // Jika terdapat relasi dengan model User, bisa gunakan ini:

}
