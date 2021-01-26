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
        $divisor = (float) $date2->diffInDays($date1);
        if ($divisor != 0) {
            $diffWeight = (float) $kontrol2->weight - (float) $kontrol1->weight;

            if ($diffWeight / $divisor >= 15.0) {
                return 'normal';
            } elseif ($diffWeight / $divisor >= 13.5 && $diffWeight / $divisor < 15.0) {
                return 'warning';
            } else {
                return 'danger';
            }
        } else {
            return 'belum';
        }
    }
    public static function panjang($kontrol1, $kontrol2)
    {
        $date1 = Carbon::parse($kontrol1->created_at);
        $date2 = Carbon::parse($kontrol2->created_at);
        $divisor = (float) $date2->diffInWeeks($date1);
        if ($divisor != 0) {
            $diffWeight = (float) $kontrol2->weight - (float) $kontrol1->weight;

            if ($diffWeight / $divisor >= 0.8 && $diffWeight / $divisor <= 1) {
                return 'normal';
            } elseif ($diffWeight / $divisor >= 0.72 && $diffWeight / $divisor <= 1.1) {
                return 'warning';
            } else {
                return 'danger';
            }
        } else {
            return 'belum';
        }
    }
    public static function lingkar($kontrol1, $kontrol2)
    {
        $date1 = Carbon::parse($kontrol1->created_at);
        $date2 = Carbon::parse($kontrol2->created_at);
        $divisor = (float) $date2->diffInWeeks($date1);
        if ($divisor != 0) {
            $diffWeight = (float) $kontrol2->weight - (float) $kontrol1->weight;

            if ($diffWeight / $divisor >= 0.5 && $diffWeight / $divisor <= 0.8) {
                return 'normal';
            } elseif ($diffWeight / $divisor >= 0.45 && $diffWeight / $divisor <= 0.88) {
                return 'warning';
            } else {
                return 'danger';
            }
        } else {
            return 'belum';
        }
    }
}
