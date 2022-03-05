<?php

namespace App\Exports;

use App\Models\UserLog;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserLogsExport implements FromQuery, withHeadings, withMapping, WithColumnFormatting
{

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        // TODO: Implement query() method.
        return UserLog::query();
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
    public function map($log): array
    {
        // TODO: Implement map() method.
        return [
            $log->user->profile_name,

        ];
    }
}
