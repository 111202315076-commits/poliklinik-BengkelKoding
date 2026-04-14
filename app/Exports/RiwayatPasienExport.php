<?php

namespace App\Exports;

use App\Models\DaftarPoli;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class RiwayatPasienExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return DaftarPoli::with(['pasien', 'periksa'])
            ->whereHas('jadwalPeriksa', function($q) {
                $q->where('id_dokter', Auth::user()->id);
            })
            ->where('status_periksa', '1')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pasien',
            'No. RM',
            'Keluhan',
            'Tanggal Periksa',
            'Catatan',
            'Biaya',
        ];
    }

    public function map($riwayat): array
    {
        return [
            $riwayat->id,
            $riwayat->pasien->name ?? '-',
            $riwayat->pasien->no_rm ?? '-',
            $riwayat->keluhan,
            $riwayat->periksa ? $riwayat->periksa->tgl_periksa : '-',
            $riwayat->periksa ? $riwayat->periksa->catatan : '-',
            $riwayat->periksa ? $riwayat->periksa->biaya_periksa : '-',
        ];
    }
}
