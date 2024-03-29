<?php

namespace App\Exports;

use App\Models\PatientProfile;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PatientsExport implements FromQuery, withHeadings, withMapping, WithColumnFormatting
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
            $patient->baby_gender == 'male'? 'L':'P',
            Date::dateTimeToExcel(Carbon::parse($patient->hospital_entry)),
            Date::dateTimeToExcel(Carbon::parse($patient->return_date)),
            Carbon::parse($patient->return_date)->diffInHours(Carbon::parse($patient->hospital_entry)), //nb: lama rawat bayi
            Carbon::parse($patient->return_date)->diffInDays(Carbon::parse($patient->hospital_entry)), //nb: lama rawat bayi
            $patient->usia_gestas,
            $patient->born_weight, // berat badan lahir
            $patient->current_weight, // berat badan sekarang
            $patient->born_length, // panjang badan lahir
            $patient->current_length, // panjang badan sekarang
            $patient->mother_name,
            Date::dateTimeToExcel(Carbon::parse($patient->mother_birthday)),
            Carbon::parse($patient->mother_birthday)->diffInYears(now()), // usia ibu
            $patient->mother_education,
            $patient->mother_job,
            $patient->paritas,
            $patient->pendapatan_keluarga == 'kd3'? '<3 juta':'>=3 juta',
            $patient->pengalaman_merawat == 1? 'ya':'tidak',
            $patient->harapan_orangtua == 1? 'ya':'tidak',
            $patient->father_name,
            Date::dateTimeToExcel(Carbon::parse($patient->father_birthday)),
            Carbon::parse($patient->father_birthday)->diffInYears(now()), // usia bapak
            $patient->father_education,
            $patient->father_job,
            Date::dateTimeToExcel($patient->created_at),
        ];
    }

    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'C' => NumberFormat::FORMAT_DATE_DATETIME,
            'D' => NumberFormat::FORMAT_DATE_DATETIME,
            'M' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'V' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Z' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'Nama Bayi',
            'Jenis Kelamin Bayi',
            'Tanggal masuk rumah sakit',
            'Tanggal keluar rumah sakit',
            'Lama Rawat Bayi(jam)',
            'Lama Rawat Bayi(hari)',
            'Usia Gestasi',
            'Berat Badan Lahir',
            'Berat Badan Bayi',
            'Panjang Badan Lahir',
            'Panjang Badan Bayi',
            'Nama Ibu',
            'Tanggal lahir ibu',
            'Usia Ibu',
            'Pendidikan Ibu',
            'Pekerjaan Ibu',
            'Paritas',
            'Pendapatan Keluarga',
            'Pengalaman merawat BBLR',
            'Anak yang diharapkan',
            'Nama Bapak',
            'Tanggal lahir Bapak',
            'Usia Bapak',
            'Pendidikan Bapak',
            'Pekerjaan Bapak',
            'created at',
        ];
    }
}
