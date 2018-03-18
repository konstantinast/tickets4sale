<?php

namespace App\Factory;

use App\BusinessRules\ShowTiming;
use App\Domain\ShowStatus;

abstract class ShowStatusFactory
{
    public static function create(int $whichShowDay, int $whichSaleDay): ShowStatus
    {
        if ($whichShowDay > ShowTiming::$showDuration || $whichSaleDay > ShowTiming::$ticketSaleStartsBefore) {
            // In the past
            return new ShowStatus(ShowStatus::in_the_past);
        } else {
            if ($whichSaleDay > 0) {
                // Open for sale
                return new ShowStatus(ShowStatus::open_for_sale);
            } else {
                // Sale not started
                return new ShowStatus(ShowStatus::sale_not_started);
            }
        }
    }
}