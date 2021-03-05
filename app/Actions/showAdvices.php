<?php


namespace App\Actions;


class showAdvices
{
    public static function handle($advices)
    {
        $array = array();
        $i = 0;
        foreach ($advices as $advice) {
            $array[$i] = $advice;
            ++$i;
        }
        return $array;
    }
}
