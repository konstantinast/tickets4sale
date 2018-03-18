<?php


namespace App\Factory;

use App\BusinessRules\ShowTicketPricing;
use App\Domain\ShowGenre;
use App\Domain\ShowInfo;
use App\Domain\ShowSaleDetails;
use App\Domain\ShowStatus;

abstract class ShowInfoFactory
{
    public static function create(
        string $title,
        \DateTime $openingDate,
        \DateTime $showDate,
        \DateTime $queryDate,
        ShowGenre $showGenre
    ): ShowInfo {
        $whichShowDay = ShowSaleDetails::getWhichShowDayItIs($openingDate, $showDate);
        $whichSaleDay = ShowSaleDetails::getWhichDayOfSale($queryDate, $showDate);
        $showTicketPricing = new ShowTicketPricing($showGenre);
        $showDiscountDetails = ShowDiscountDetailsFactory::create($openingDate, $showDate);
        $discount = $showDiscountDetails->getDiscount();

        $showStatus = ShowStatusFactory::create($whichShowDay, $whichSaleDay);

        $ticketsLeft = 0; // default
        $ticketsAvailable = 0; // default
        $price = $showTicketPricing->getPrice() * ((100 - $discount) / 100);

        // Calculate based on client specs
        $saleDetails = new ShowSaleDetails($openingDate, $showDate);

        $location = $saleDetails->getLocation();

        if (
            $showStatus->equals(new ShowStatus(ShowStatus::sale_not_started))
            ||
            $showStatus->equals(new ShowStatus(ShowStatus::open_for_sale))
        ) {
            $hallCapacity = $saleDetails->getHallCapacity();

            if ($showStatus->equals(new ShowStatus(ShowStatus::sale_not_started))) {
                $ticketsAvailablePerDay = 0;
            } else {
                $ticketsAvailablePerDay = $saleDetails->getTicketsAvailablePerDay();
            }

            // Calculate the values we are after
            $howManyDaysBeforeTicketsWereAlreadySold = $whichSaleDay - 1; // -1 because we do not count current day
            $ticketsLeft = $hallCapacity - ($howManyDaysBeforeTicketsWereAlreadySold * $ticketsAvailablePerDay);

            // Cannot sell what we do not have
            if ($ticketsLeft <= 0) {
                $ticketsLeft = 0;
            }

            if ($ticketsLeft < $ticketsAvailablePerDay) {
                $ticketsAvailable = $ticketsLeft;
            } else {
                $ticketsAvailable = $ticketsAvailablePerDay;
            }

            if ($ticketsLeft === 0) {
                $showStatus = new ShowStatus(ShowStatus::sold_out);
            }
        }

        $instance = new ShowInfo($title, $ticketsLeft, $ticketsAvailable, $showStatus, $location, $price);

        return $instance;
    }
}