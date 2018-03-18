<?php


namespace App\Factory;

use App\BusinessRules\ShowDiscountDetails;
use App\Domain\ShowSaleDetails;

class ShowDiscountDetailsFactory
{
    public static function create(\DateTime $openingDate, \DateTime $showDate): ShowDiscountDetails
    {
        $whichShowDay = ShowSaleDetails::getWhichShowDayItIs($openingDate, $showDate);
        $showDiscountDetails = new ShowDiscountDetails($whichShowDay);

        return $showDiscountDetails;
    }
}