<?php

namespace App\BusinessRules;

use App\Domain\ShowLocation;
use App\Domain\ShowSaleDetails;

class ShowLocationDetails
{
    // Settings
    protected static $hallCapacityValues = [
        ShowLocation::big_hall => 200,
        ShowLocation::small_hall => 100,
        ShowLocation::unknown => 0
    ];

    protected static $showDayFromToIntervalValues = [
        ShowLocation::big_hall => [
            'from' => 1,
            'to' => 60
        ],
        ShowLocation::small_hall => [
            'from' => 61,
            'to' => 100
        ],
        ShowLocation::unknown => [
            'from' => 101,
            'to' => INF // not sure if this is a good idea, but yolo :D
        ]
    ];

    protected $intervalStartDay;
    protected $intervalEndDay;

    private $hallCapacity;
    private $location;

    public function __construct(ShowLocation $showLocation)
    {
        $this->location = $showLocation;
        $this->hallCapacity = self::$hallCapacityValues[(string)$showLocation];
        $intervalFromTo = self::$showDayFromToIntervalValues[(string)$showLocation];
        $this->intervalStartDay = $intervalFromTo['from'];
        $this->intervalEndDay = $intervalFromTo['to'];
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
    public function getIntervalStartDay(): int
    {
        return $this->intervalStartDay;
    }

    /**
     * @return int
     */
    public function getIntervalEndDay(): int
    {
        return $this->intervalEndDay;
    }

    public static function whichLocation(\DateTime $openingDate, \DateTime $showDate): ShowLocation
    {
        $whichShowDay = ShowSaleDetails::getWhichShowDayItIs($openingDate, $showDate);
        $showLocation = null;

        // Iterate over settings and find the right one
        foreach (self::$showDayFromToIntervalValues as $location => $interval) {
            if ($interval['from'] <= $whichShowDay && $whichShowDay <= $interval['to']) {
                $showLocation = new ShowLocation($location);
            }
        }

        return $showLocation;
    }

    /**
     * @return ShowLocation
     */
    public function getLocation(): ShowLocation
    {
        return $this->location;
    }
}