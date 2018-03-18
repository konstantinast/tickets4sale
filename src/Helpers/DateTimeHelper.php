<?php


namespace App\Helpers;


abstract class DateTimeHelper
{
    public static function daysInPast(\DateTime $current, \DateTime $past): int
    {
        return $current->diff($past)->format('%r%a');
    }

    /*
     * Getting new date, when we assume, that $passedDate is inclusive
     */
    public static function getDateInNDays(\DateTime $passedDate, $nDays): \DateTime
    {
        $sign = $nDays <=> 0;
        $amountOfDays = abs($nDays);
        $diffDays = $amountOfDays - 1;
        $newDate = (clone $passedDate)->modify(($sign * $diffDays) . 'days');

        return $newDate;
    }
}