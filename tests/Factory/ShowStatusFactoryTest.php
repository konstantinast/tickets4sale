<?php

namespace App\Tests\Factory;

use App\BusinessRules\ShowTiming;
use App\Domain\ShowSaleDetails;
use App\Domain\ShowStatus;
use App\Factory\ShowStatusFactory;
use App\Helpers\DateTimeHelper;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ShowStatusFactoryTest extends TestCase
{
    /*
     * > Ticket sale starts 25 days before a show starts;
     */
    public function testTicketSaleStarts25DaysBeforeShowStarts()
    {
        // Settings
        $ticketSaleStartsBefore = ShowTiming::$ticketSaleStartsBefore;
        $openingDate = new \DateTime();
        $queryDate = DateTimeHelper::getDateInNDays($openingDate, -1 * $ticketSaleStartsBefore);
        $showDate = clone $openingDate;

        // Test data
        $whichShowDay = ShowSaleDetails::getWhichShowDayItIs($openingDate, $showDate);
        $whichSaleDay = ShowSaleDetails::getWhichDayOfSale($queryDate, $showDate);
        $showStatus = ShowStatusFactory::create($whichShowDay, $whichSaleDay);

        // Expected
        $expectedTicketSaleStartsBefore = 25;
        $expectedShowStatus = new ShowStatus(ShowStatus::open_for_sale);


        // Assertions
        $this->assertEquals($expectedTicketSaleStartsBefore, $ticketSaleStartsBefore);
        $this->assertEquals($expectedShowStatus, $showStatus);
    }

    /*
     * > Ticket sale starts 25 days before a show starts;
     */
    public function testTicketSaleDoesNotStartEarlierThan25DaysBeforeShowStarts()
    {
        // Settings
        $openingDate = new \DateTime();
        $queryDate = DateTimeHelper::getDateInNDays($openingDate, -1 * (ShowTiming::$ticketSaleStartsBefore + 1)); // 1 day earlier
        $showDate = clone $openingDate;

        // Test data
        $whichShowDay = ShowSaleDetails::getWhichShowDayItIs($openingDate, $showDate);
        $whichSaleDay = ShowSaleDetails::getWhichDayOfSale($queryDate, $showDate);
        $showStatus = ShowStatusFactory::create($whichShowDay, $whichSaleDay);

        // Expected
        $expectedShowStatus = new ShowStatus(ShowStatus::sale_not_started);

        // Assertions
        $this->assertEquals($expectedShowStatus, $showStatus);
    }
}