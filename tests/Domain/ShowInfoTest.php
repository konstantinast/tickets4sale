<?php

namespace App\Tests\Domain;

use App\BusinessRules\ShowLocationDetails;
use App\BusinessRules\ShowTiming;
use App\Domain\Show;
use App\Domain\ShowGenre;
use App\Domain\ShowInfo;
use App\Domain\ShowLocation;
use App\Domain\ShowStatus;
use App\Helpers\DateTimeHelper;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ShowInfoTest extends TestCase
{
    /*
     * > - Each day a fixed number of tickets is available for sales:
     * >    - 10 tickets for shows in the big hall;
     */
    public function testThatEachDayAFixedNumberOfTicketsIsAvailableForSaleInBigHall()
    {
        // Test data
        $showInfo = $this->getShowInBigHallShowInfoOnFirstSaleDay();
        $showLocation = $showInfo->getLocation();
        $ticketsAvailable = $showInfo->getTicketsAvailable();

        // Expectations
        $expectedShowLocation = new ShowLocation(ShowLocation::big_hall);
        $expectedTicketsAvailable = 10;

        // Test
        $this->assertEquals($expectedShowLocation, $showLocation);
        $this->assertEquals($expectedTicketsAvailable, $ticketsAvailable);
    }

    /*
     * > - Each day a fixed number of tickets is available for sales:
     * >    - 5 tickets for shows in the small hall;
     */
    public function testThatEachDayAFixedNumberOfTicketsIsAvailableForSaleInSmallHall()
    {
        // Test data
        $showInfo = $this->getShowInSmallHallShowInfoOnFirstSaleDay();
        $showLocation = $showInfo->getLocation();
        $ticketsAvailable = $showInfo->getTicketsAvailable();

        // Expectations
        $expectedShowLocation = new ShowLocation(ShowLocation::small_hall);
        $expectedTicketsAvailable = 5;

        // Test
        $this->assertEquals($expectedShowLocation, $showLocation);
        $this->assertEquals($expectedTicketsAvailable, $ticketsAvailable);
    }

    /*
     * > Consequently, 5 days before the show starts it is always sold out.
     */
    public function testThat5DaysBeforeItIsSoldOut()
    {
        // Test data
        $showInfo = $this->getShowInSmallHallShowInfo5daysBeforePerformance();
        $ticketsAvailable = $showInfo->getTicketsAvailable();
        $ticketsLeft = $showInfo->getTicketsLeft();
        $showStatus = $showInfo->getStatus();

        // Expectations
        $expectedTicketsAvailable = 0;
        $expectedTicketsLeft = 0;
        $expectedShowStatus = new ShowStatus(ShowStatus::sold_out);

        // Test
        $this->assertEquals($expectedTicketsAvailable, $ticketsAvailable);
        $this->assertEquals($expectedTicketsLeft, $ticketsLeft);
        $this->assertEquals($expectedShowStatus, $showStatus);
    }

    /*
     * > Consequently, 5 days before the show starts it is always sold out.
     *
     * Test the near the limit
     */
    public function testThat6DaysBeforeItIsNotSoldOut()
    {
        // Test data
        $showInfo = $this->getShowInSmallHallShowInfo6daysBeforePerformance();
        $ticketsAvailable = $showInfo->getTicketsAvailable();
        $ticketsLeft = $showInfo->getTicketsLeft();
        $showStatus = $showInfo->getStatus();

        // Expectations
        $expectedTicketsAvailable = 5;
        $expectedTicketsLeft = 5;
        $notExpectedShowStatus = new ShowStatus(ShowStatus::sold_out);

        // Test
        $this->assertEquals($expectedTicketsAvailable, $ticketsAvailable);
        $this->assertEquals($expectedTicketsLeft, $ticketsLeft);
        $this->assertNotEquals($notExpectedShowStatus, $showStatus);
    }

    private function getShowInBigHallShowInfoOnFirstSaleDay(): ShowInfo
    {
        // Settings
        $title = 'Assumptions';
        $openingDay = new \DateTime();
        $genre = new ShowGenre(ShowGenre::musical);

        // Make sure it is in the big hall
        $showDate = clone $openingDay;
        $queryDate = DateTimeHelper::getDateInNDays($showDate, -1 * ShowTiming::$ticketSaleStartsBefore);

        // Create
        $show = new Show($title, $openingDay, $genre);
        $showInfo = $show->getShowInfo($showDate, $queryDate);

        return $showInfo;
    }


    private function getShowInSmallHallShowInfoOnFirstSaleDay()
    {
        // Settings
        $title = 'Assumptions';
        $openingDay = new \DateTime();
        $genre = new ShowGenre(ShowGenre::musical);

        // Make sure it is in the small hall
        $showLocationDetails = new ShowLocationDetails(new ShowLocation(ShowLocation::small_hall));
        $showDate = DateTimeHelper::getDateInNDays($openingDay, $showLocationDetails->getIntervalStartDay());
        $queryDate = DateTimeHelper::getDateInNDays($showDate, -1 * ShowTiming::$ticketSaleStartsBefore);

        // Create
        $show = new Show($title, $openingDay, $genre);
        $showInfo = $show->getShowInfo($showDate, $queryDate);

        return $showInfo;
    }

    private function getShowInSmallHallShowInfo5daysBeforePerformance()
    {
        // Settings
        $title = 'Assumptions';
        $openingDay = new \DateTime();
        $genre = new ShowGenre(ShowGenre::musical);

        // Make sure it is in the small hall
        $showLocationDetails = new ShowLocationDetails(new ShowLocation(ShowLocation::small_hall));
        $showDate = DateTimeHelper::getDateInNDays($openingDay, $showLocationDetails->getIntervalStartDay());
        $queryDate = DateTimeHelper::getDateInNDays($showDate, -5);

        // Create
        $show = new Show($title, $openingDay, $genre);
        $showInfo = $show->getShowInfo($showDate, $queryDate);

        return $showInfo;
    }

    private function getShowInSmallHallShowInfo6daysBeforePerformance()
    {
        // Settings
        $title = 'Assumptions';
        $openingDay = new \DateTime();
        $genre = new ShowGenre(ShowGenre::musical);

        // Make sure it is in the small hall
        $showLocationDetails = new ShowLocationDetails(new ShowLocation(ShowLocation::small_hall));
        $showDate = DateTimeHelper::getDateInNDays($openingDay, $showLocationDetails->getIntervalStartDay());
        $queryDate = DateTimeHelper::getDateInNDays($showDate, -6);

        // Create
        $show = new Show($title, $openingDay, $genre);
        $showInfo = $show->getShowInfo($showDate, $queryDate);

        return $showInfo;
    }
}