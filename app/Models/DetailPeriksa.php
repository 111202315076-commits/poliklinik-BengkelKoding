<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeriksa extends Model
{
    use HasFactory;

    protected $table = 'detail_periksa';

    protected $fillable = [
        'id_periksa',
        'id_obat',
    ];

    /**
     * Relasi ke model Periksa
     * Detail periksa ini merujuk pada satu transaksi pemeriksaan
     */
    public function periksa()
    {
        return $this->belongsTo(Periksa::class, 'id_periksa');
    }

    /**
     * Relasi ke model Obat
     * Mengetahui obat apa yang ada di detail pemeriksaan ini
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}