<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    protected $table = 'poli';

    protected $fillable = [
        'nama_poli',
        'keterangan',
    ];

    /**
     * Relasi ke model Dokter
     * Memungkinkan Admin melihat semua dokter yang terdaftar di poli ini
     */
    public function dokters()
    {
        return $this->hasMany(User::class, 'id_poli', 'id')->where('role', 'dokter');
    }
}