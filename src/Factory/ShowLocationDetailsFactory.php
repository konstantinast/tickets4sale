<?php

namespace App\Factory;

use App\BusinessRules\ShowLocationDetails;

abstract class ShowLocationDetailsFactory
{
    public static function create(\DateTime $openingDate, \DateTime $showDate)
    {
        $location = ShowLocationDetails::whichLocation($openingDate, $showDate);
        $locationDetails = new ShowLocationDetails($location);

        return $locationDetails;
    }
}