<?php


namespace App\Actions;


class ReversePoint
{
    public static function PSS(int $answer)
    {
        if ($answer == 0) {
            $point = 4;
        } elseif ($answer == 1) {
            $point = 3;
        } elseif ($answer == 2) {
            $point = $answer;
        } elseif ($answer == 3) {
            $point = 1;
        } else {
            $point = 0;
        }

        return $point;
    }

    public static function MCS(int $answer)
    {
        if ($answer == 1) {
            $point = 5;
        } elseif ($answer == 2) {
            $point = 4;
        } elseif ($answer == 3) {
            $point = 3;
        } elseif ($answer == 4) {
            $point = 2;
        } else {
            $point = 1;
        }

        return $point;
    }
}
