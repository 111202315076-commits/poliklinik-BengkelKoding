<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPeriksa extends Model
{
    use HasFactory;

    protected $table = 'jadwal_periksa';

    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    /**
     * Relasi ke model Dokter
     * Sangat penting untuk Admin agar bisa menampilkan nama Dokter di tabel Jadwal
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }
    /**
     * Relasi ke pendaftaran poli
     * Mengetahui siapa saja pasien yang mendaftar di jadwal ini
     */
    public function daftarPolis()
    {
        return $this->hasMany(DaftarPoli::class, 'id_jadwal');
    }
}