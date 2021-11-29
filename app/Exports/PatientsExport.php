<?php

namespace App\Exports;

use App\Models\PatientProfile;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PatientsExport implements FromQuery, withHeadings, withMapping
{
    use Exportable;

    /**
     * @inheritDoc
     */
    public function query()
    {
        return PatientProfile::query();
    }

    /**
     *
     * @return array
     * @var PatientProfile $patient
     */
    public function map($patient): array
    {
        return [
            $patient->baby_name,
            $patient->baby_gender,
            $patient->return_date, //nb: lama rawat bayi
            $patient->usia_gestas,
            $patient->born_weight, // berat badan lahir
            $patient->baby_name, // berat badan sekarang
            $patient->born_length, // panjang badan lahir
            $patient->baby_name, // panjang badan sekarang
            $patient->mother_name,
            Carbon::parse($patient->mother_birthday)->diffInYears(now()), // usia ibu
            $patient->mother_education,
            $patient->mother_job,
            $patient->paritas,
            $patient->pendapatan_keluarga,
            $patient->pengalaman_merawat,
            $patient->father_name,
            Carbon::parse($patient->father_birthday)->diffInYears(now()), // usia bapak
            $patient->father_education,
            $patient->father_job,
        ];
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'Nama Bayi',
            'Jenis Kelamin Bayi',
            'Lama Rawat Bayi',
            'Usia Gestasi',
            'Berat Badan Lahir',
            'Berat Badan Bayi',
            'Panjang Badan Lahir',
            'Panjang Badan Bayi',
            'Nama Ibu',
            'Usia Ibu',
            'Pendidikan Ibu',
            'Pekerjaan Ibu',
            'Paritas',
            'Pendapatan Keluarga',
            'Pengalaman merawat BBLR',
            'Nama Bapak',
            'Usia Bapak',
            'Pendidikan Bapak',
            'Pekerjaan Bapak',
        ];
    }
}
