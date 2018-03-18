<?php

namespace App\Factory;

use App\BusinessRules\ShowLocationDetails;
use App\BusinessRules\ShowTicketAvailability;

class ShowTicketAvailabilityFactory
{
    public static function create(\DateTime $openingDate, \DateTime $showDate)
    {
        $showLocation = ShowLocationDetails::whichLocation($openingDate, $showDate);
        $showTicketAvailability = new ShowTicketAvailability($showLocation);

        return $showTicketAvailability;
    }
}