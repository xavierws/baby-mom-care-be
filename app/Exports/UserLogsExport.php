<?php

namespace App\Exports;

use App\Models\UserLog;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserLogsExport implements FromQuery, withHeadings, withMapping, WithColumnFormatting
{
    use Exportable;

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        // TODO: Implement query() method.
//        return DB::table('user_logs')->select(DB::raw('count(*) as log_count, log, user_id, created_at'))
//            ->groupBy('user_id')
//            ->get();

        return UserLog::query()
            ->select(DB::raw('count(*) as log_count, log, user_id, created_at'))
            ->groupBy('user_id');
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'D' => NumberFormat::FORMAT_DATE_DATETIME
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'username',
            'log',
            'count',
            'created at'
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        // TODO: Implement map() method.
        return [
            $row->user->profile_name,
            $row->log,
            $row->log_count,
            $row->created_at
        ];
    }
}
