<?php

namespace App\Exports;

use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SurveysExport implements FromQuery, withHeadings, withMapping, WithColumnFormatting
{
    use Exportable;

    /**
     * @return Builder
     */
    public function query()
    {
        // TODO: Implement query() method.
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // TODO: Implement headings() method.
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        // TODO: Implement map() method.
    }
}
