<?php

namespace App\Exports;

use App\Models\JadwalPeriksa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return JadwalPeriksa::where('id_dokter', Auth::user()->id)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Hari',
            'Jam Mulai',
            'Jam Selesai',
        ];
    }

    public function map($jadwal): array
    {
        return [
            $jadwal->id,
            $jadwal->hari,
            $jadwal->jam_mulai,
            $jadwal->jam_selesai,
        ];
    }
}
