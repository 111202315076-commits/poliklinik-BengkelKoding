<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokters';

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'id_poli'
    ];

    /**
     * Relasi ke model Poli
     * Mengetahui dokter ini bertugas di poli mana
     */
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli');
    }

    /**
     * Relasi ke model JadwalPeriksa
     * Seorang dokter bisa memiliki banyak jadwal praktik
     */
    public function jadwalPeriksa()
    {
        return $this->hasMany(JadwalPeriksa::class, 'id_dokter');
    }
}