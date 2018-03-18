<?php

namespace App\Tests\Domain;

use App\BusinessRules\ShowTiming;
use App\Domain\ShowSaleDetails;
use App\Helpers\DateTimeHelper;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ShowSaleDetailsTest extends TestCase
{
    public function testWhichSaleDayWhenItIsTheFirstSaleDay()
    {
        // Test settings
        $showDate = new \DateTime();
        $queryDate = DateTimeHelper::getDateInNDays($showDate, -1 * ShowTiming::$ticketSaleStartsBefore);

        // Expectations
        $expectedWhichDayOfSale = 1; // 1-st

        // Test data
        $whichDayOfSale = ShowSaleDetails::getWhichDayOfSale($queryDate, $showDate);

        // Test
        $this->assertEquals($expectedWhichDayOfSale, $whichDayOfSale);
    }

    public function testWhichSaleDayWhenItIsLastSaleDay()
    {
        // Test settings
        $showDate = new \DateTime();
        $queryDate = clone $showDate;

        // Expectations
        $expectedWhichDayOfSale = ShowTiming::$ticketSaleStartsBefore; // N-th

        // Test data
        $whichDayOfSale = ShowSaleDetails::getWhichDayOfSale($queryDate, $showDate);

        // Test
        $this->assertEquals($expectedWhichDayOfSale, $whichDayOfSale);
    }

    public function testGetDiscountReturnValuesAsExpected()
    {
        // Test settings
        $openingDate = new \DateTime();
        $showDate1 = DateTimeHelper::getDateInNDays($openingDate, 80);
        $showDate2 = DateTimeHelper::getDateInNDays($openingDate, 81);

        $showSaleDetails1 = new ShowSaleDetails($openingDate, $showDate1);
        $showSaleDetails2 = new ShowSaleDetails($openingDate, $showDate2);

        $discount1 = $showSaleDetails1->getDiscount();
        $expectedDiscount1 = 0;

        $discount2 = $showSaleDetails2->getDiscount();
        $expectedDiscount2 = 20;

        // Test
        $this->assertEquals($expectedDiscount1, $discount1);
        $this->assertEquals($expectedDiscount2, $discount2);
    }
}