<?php


namespace App\Actions;


use App\Models\Kontrol;
use App\Models\PatientProfile;
use Carbon\Carbon;

class CountFormula
{
    public static function handle($kontrol1, $kontrol2)
    {
        $date1 = Carbon::parse($kontrol1->date);
        $date2 = Carbon::parse($kontrol2->date);
        $divisor = (float) $date2->diffInDays($date1);
        if ($divisor != 0) {
            $diffWeight = (float) $kontrol2->weight - (float) $kontrol1->weight;

            if ($diffWeight / $divisor >= 15.0) {
                return 'normal';
            } elseif ($diffWeight / $divisor < 15.0) {
                return 'warning';
            }
        } else {
            return 'belum';
        }
    }

    public static function panjang($kontrol1, $kontrol2)
    {
        $date1 = Carbon::parse($kontrol1->date);
        $date2 = Carbon::parse($kontrol2->date);
        $divisor = (float) $date2->diffInWeeks($date1);
        if ($divisor != 0) {
            $diffLength = (float) $kontrol2->length - (float) $kontrol1->length;

            if ($diffLength / $divisor >= 0.8 && $diffLength / $divisor <= 1) {
                return 'normal';
            } else {
                return 'warning';
            }
        } else {
            return 'belum';
        }
    }

    public static function lingkar($kontrol1, $kontrol2)
    {
        $date1 = Carbon::parse($kontrol1->date);
        $date2 = Carbon::parse($kontrol2->date);
        $divisor = (float) $date2->diffInWeeks($date1);
        if ($divisor != 0) {
            $diffLingkar = (float) $kontrol2->lingkar_kepala - (float) $kontrol1->lingkar_kepala;

            if ($diffLingkar / $divisor >= 0.5 && $diffLingkar / $divisor <= 0.8) {
                return 'normal';
            } else {
                return 'warning';
            }
        } else {
            return 'belum';
        }
    }
}
