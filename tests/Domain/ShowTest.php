<?php

namespace App\Tests\Domain;

use App\Domain\Show;
use App\Domain\ShowGenre;
use App\Domain\ShowInfo;
use App\Domain\ShowLocation;
use App\Domain\ShowStatus;
use App\Helpers\DateTimeHelper;
use PHPUnit\Framework\TestCase;


class ShowTest extends TestCase
{
    public function testGetShowInfo()
    {
        $title = 'Cats';
        $openingDay = new \DateTime('2017-06-01');
        $genre = new ShowGenre(ShowGenre::musical);

        $showInstance = new Show($title, $openingDay, $genre);

        // Test settings
        $queryDate = new \DateTime('2017-01-01');
        $showDate = new \DateTime('2017-07-01');
        $showInfoInstanceExpected = new ShowInfo(
            'cats',
            200,
            0,
            new ShowStatus(ShowStatus::sale_not_started),
            new ShowLocation(ShowLocation::big_hall)
        );

        // The test
        $showInfoInstance = $showInstance->getShowInfo($showDate, $queryDate);

        $this->assertEquals(
            $showInfoInstanceExpected->getTitle(),
            $showInfoInstance->getTitle()

        );

        $this->assertEquals(
            $showInfoInstanceExpected->getTicketsLeft(),
            $showInfoInstance->getTicketsLeft()
        );

        $this->assertEquals(
            $showInfoInstanceExpected->getTicketsAvailable(),
            $showInfoInstance->getTicketsAvailable()
        );

        $this->assertEquals(
            $showInfoInstanceExpected->getStatus(),
            $showInfoInstance->getStatus()
        );
    }

    /*
     * Test:
     *
     * > So, consider today, if a show opened 20 days ago, then there are 100 tickets left for the
     * > performance of the same show in 60 days (that is the 80th performance of this show and will be
     * > held in the small hall), and ticket sale for that day hasn’t started yet.
     */
    public function testGetShowInfoAssumption1FromClientSpecs()
    {
        // Test settings
        $queryDate = new \DateTime(); // > So, consider today
        $showStartDate = DateTimeHelper::getDateInNDays($queryDate, -20); // > if a show opened 20 days ago
        $showDate = DateTimeHelper::getDateInNDays($queryDate, 60); // > for the performance of the same show in 60 days

        // Expectancies
        $expectedTicketsLeft = 100; // > 100 tickets left
        $expectedStatus = new ShowStatus(ShowStatus::sale_not_started); // > ticket sale for that day hasn’t started yet
        $expectedLocation = new ShowLocation(ShowLocation::small_hall); // > will be held in the small hall

        // Test data
        $title = 'Assumptions';
        $genre = new ShowGenre(ShowGenre::musical);

        $showInstance = new Show($title, $showStartDate, $genre);

        // The test
        $showInfoInstance = $showInstance->getShowInfo($showDate, $queryDate);

        $this->assertEquals(
            $expectedTicketsLeft,
            $showInfoInstance->getTicketsLeft()
        );

        $this->assertEquals(
            $expectedStatus,
            $showInfoInstance->getStatus()
        );

        $this->assertEquals(
            $expectedLocation,
            $showInfoInstance->getLocation()
        );
    }

    /*
     * Precondition:
     *
     * > So, consider today, if a show opened 20 days ago, then there are 100 tickets left for the
     * > performance of the same show in 60 days (that is the 80th performance of this show and will be
     * > held in the small hall), and ticket sale for that day hasn’t started yet.
     *
     * Test:
     *
     * > For the same show, there are
     * > 50 tickets left for the performance in 10 days, and 10 tickets up for sale (that is the 30rd
     * > performance of this show and will be held in the big hall).
     */
    public function testGetShowInfoAssumption2ClientSpecs()
    {
        // Precondition settings
        $preconditionTodayDate = new \DateTime(); // > So, consider today
        $preconditionShowStartDate = DateTimeHelper::getDateInNDays(clone $preconditionTodayDate,
            -20); // > if a show opened 20 days ago

        // Test settings
        $queryDate = $preconditionTodayDate; // > For the same show
        $showStartDate = $preconditionShowStartDate; // > For the same show
        $showDate = DateTimeHelper::getDateInNDays($preconditionTodayDate,
            10); // > for the performance in 10 days ... (that is the 30rd performance of this show

        // Expectancies
        $expectedTicketsLeft = 50; // > there are 50 tickets left
        $expectedLocation = new ShowLocation(ShowLocation::big_hall); // > and will be held in the big hall

        // Test data
        $title = 'Assumptions';
        $genre = new ShowGenre(ShowGenre::musical);

        $showInstance = new Show($title, $showStartDate, $genre);

        // The test
        $showInfoInstance = $showInstance->getShowInfo($showDate, $queryDate);

        $this->assertEquals(
            $expectedTicketsLeft,
            $showInfoInstance->getTicketsLeft()
        );

        $this->assertEquals(
            $expectedLocation,
            $showInfoInstance->getLocation()
        );
    }

    public function testWhetherPassedShowContainsStatusInThePast()
    {
        // Settings
        $title = 'Assertions';
        $openingDay = new \DateTime('2017-06-01');
        $genre = new ShowGenre(ShowGenre::musical);
        $queryDate = new \DateTime('2018-01-01');
        $showDate = new \DateTime('2018-07-01');

        // Test data
        $show = new Show($title, $openingDay, $genre);
        $showInfo = $show->getShowInfo($showDate, $queryDate);
        $showStatus = $showInfo->getStatus();

        // Expectations
        $expectedShowStatus = new ShowStatus(ShowStatus::in_the_past);

        // The test
        $this->assertEquals(
            $expectedShowStatus,
            $showStatus
        );
    }
}