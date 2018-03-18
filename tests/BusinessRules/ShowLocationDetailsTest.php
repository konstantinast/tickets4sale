<?php

namespace App\Tests\BusinessRules;

use App\BusinessRules\ShowLocationDetails;
use App\Domain\ShowLocation;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ShowLocationDetailsTest extends TestCase
{
    public function testGetIntervalEndDayForDifferentLocationsAreNotEqual()
    {
        $showLocation1 = new ShowLocation(ShowLocation::big_hall);
        $showLocation2 = new ShowLocation(ShowLocation::small_hall);
        $showLocationDetails1 = new ShowLocationDetails($showLocation1);
        $showLocationDetails2 = new ShowLocationDetails($showLocation2);
        $intervalEndDay1 = $showLocationDetails1->getIntervalEndDay();
        $intervalEndDay2 = $showLocationDetails2->getIntervalEndDay();

        // Test
        $this->assertNotEquals($intervalEndDay1, $intervalEndDay2);
    }

    public function testWhichLocationIsWorkingCorrect()
    {
        $showDate = new \DateTime();
        $openingDate = clone $showDate;

        $showLocation = ShowLocationDetails::whichLocation($openingDate, $showDate);
        $showLocationDetails = new ShowLocationDetails($showLocation);
        $expectedShowLocation = $showLocationDetails->getLocation();

        // Test
        $this->assertEquals($expectedShowLocation, $showLocation);
    }
}