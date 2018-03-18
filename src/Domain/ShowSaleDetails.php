<?php


namespace App\Domain;

use App\BusinessRules\ShowTiming;
use App\Factory\ShowDiscountDetailsFactory;
use App\Factory\ShowLocationDetailsFactory;
use App\Factory\ShowTicketAvailabilityFactory;
use App\Helpers\DateTimeHelper;

class ShowSaleDetails
{
    private $hallCapacity;
    private $ticketsAvailablePerDay;
    private $discount = 0; // in percent (max value 100)
    private $location;

    public function __construct(\DateTime $openingDate, \DateTime $showDate)
    {
        $showLocationDetails = ShowLocationDetailsFactory::create($openingDate, $showDate);
        $showTicketAvailability = ShowTicketAvailabilityFactory::create($openingDate, $showDate);
        $showDiscountDetails = ShowDiscountDetailsFactory::create($openingDate, $showDate);

        $this->location = $showLocationDetails->getLocation();
        $this->hallCapacity = $showLocationDetails->getHallCapacity();
        $this->ticketsAvailablePerDay = $showTicketAvailability->getTicketsPerDay();
        $this->discount = $showDiscountDetails->getDiscount();
    }

    /**
     * @return int
     */
    public function getHallCapacity(): int
    {
        return $this->hallCapacity;
    }

    /**
     * @return int
     */
    public function getTicketsAvailablePerDay(): int
    {
        return $this->ticketsAvailablePerDay;
    }

    /**
     * @return int
     */
    public function getDiscount(): int
    {
        return $this->discount;
    }

    public static function getWhichShowDayItIs(\DateTime $openingDate, \DateTime $showDate)
    {
        // + 1 to make it easier write rules against client specs
        $daysSinceOpening = DateTimeHelper::daysInPast($openingDate, $showDate) + 1;

        return $daysSinceOpening;
    }

    /*
     * Starting from 1 as in 1st
     */
    public static function getWhichDayOfSale(\DateTime $queryDate, \DateTime $showDate): int
    {
        // Lets count backwards from $showDate
        $whichDayOfSale = ShowTiming::$ticketSaleStartsBefore - DateTimeHelper::daysInPast($queryDate, $showDate);

        return $whichDayOfSale;
    }

    /**
     * @return ShowLocation
     */
    public function getLocation(): ShowLocation
    {
        return $this->location;
    }
}