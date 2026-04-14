<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Poli;
use App\Models\JadwalPeriksa;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'alamat',
        'no_ktp',
        'no_hp',
        'no_rm',
        'role',
        'id_poli',
        'email',
        'password',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli');
    }

    // dokter -> jadwal periksa
    public function jadwalPeriksa()
    {
        return $this->hasMany(JadwalPeriksa::class, 'id_dokter');
    }



    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE (UNTUK DASHBOARD & FILTER)
    |--------------------------------------------------------------------------
    */

    // ambil semua dokter
    public function scopeIsDokter($query)
    {
        return $query->where('role', 'dokter');
    }

    // ambil semua pasien
    public function scopeIsPasien($query)
    {
        return $query->where('role', 'pasien');
    }

    // ambil semua admin
    public function scopeIsAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    public function isDokter()
    {
        return $this->role === 'dokter';
    }

    public function isPasien()
    {
        return $this->role === 'pasien';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}