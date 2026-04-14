<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPoli extends Model
{
    use HasFactory;

    protected $table = 'daftar_poli';

protected $fillable = [
        'id_jadwal',
        'id_pasien',
        'keluhan',
        'no_antrian',
        'status_periksa',
    ];

    protected $casts = [
        'status_periksa' => 'string',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien')->where('role', 'pasien');
    }

    public function jadwalPeriksa()
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal');
    }

    public function periksa()
    {
        return $this->hasOne(Periksa::class, 'id_daftar_poli');
    }

    public function periksas()
    {
        return $this->hasMany(Periksa::class, 'id_daftar_poli');
    }
}