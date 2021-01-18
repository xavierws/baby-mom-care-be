<?php


namespace App\Actions;


use App\Models\Kontrol;
use App\Models\PatientProfile;
use Carbon\Carbon;

class CountFormula
{
    public static function handle($kontrol1, $kontrol2)
    {
        $date1 = Carbon::parse($kontrol1->created_at);
        $date2 = Carbon::parse($kontrol2->created_at);
        $divisor = (float)$date2->diffInDays($date1);

        $diffWeight = (float)$kontrol2->weight - (float)$kontrol1->weight;

        if ($diffWeight/$divisor >= 15.0) {
            return 'normal';
        } elseif ($diffWeight/$divisor >= 13.5 && $diffWeight/$divisor < 15.0) {
            return 'warning';
        } else {
            return 'danger';
        }
    }
}
