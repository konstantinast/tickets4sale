<?php

namespace App\BusinessRules;

use App\Domain\ShowLocation;

class ShowTicketAvailability
{
    private $ticketsPerDay;

    public function __construct(ShowLocation $showLocation)
    {
        switch ($showLocation) {
            case ShowLocation::big_hall:
                $this->ticketsPerDay = 10;
                break;
            case ShowLocation::small_hall:
                $this->ticketsPerDay = 5;
                break;
            default:
            case ShowLocation::unknown:
                $this->ticketsPerDay = 0;
                break;
        }
    }

    /**
     * @return int
     */
    public function getTicketsPerDay(): int
    {
        return $this->ticketsPerDay;
    }
}