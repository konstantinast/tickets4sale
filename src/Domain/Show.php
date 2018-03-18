<?php


namespace App\Domain;

use App\BusinessRules\ShowTiming;
use App\Factory\ShowInfoFactory;

class Show
{
    private $title;
    private $duration;
    private $ticketSaleStartsBefore;
    private $openingDay;
    private $genre;

    /**
     * Show constructor.
     * @param $title
     * @param $openingDay
     * @param $genre
     */
    public function __construct(String $title, \DateTime $openingDay, ShowGenre $genre)
    {
        $this->title = $title;
        $this->openingDay = $openingDay;
        $this->duration = ShowTiming::$showDuration;
        $this->ticketSaleStartsBefore = ShowTiming::$ticketSaleStartsBefore;
        $this->genre = $genre;
    }

    public function getShowInfo(\DateTime $showDate, \DateTime $queryDate): ShowInfo
    {
        $showInfo = ShowInfoFactory::create($this->title, $this->openingDay, $showDate, $queryDate, $this->genre);

        return $showInfo;
    }

    public function isItShownOnThisDay(\DateTime $showDate)
    {
        $whichShowDay = ShowSaleDetails::getWhichShowDayItIs($this->openingDay, $showDate);

        if (1 <= $whichShowDay && $whichShowDay <= ShowTiming::$showDuration) {
            return true;
        }

        return false;
    }

    /**
     * @return String
     */
    public function getTitle(): String
    {
        return $this->title;
    }

    /**
     * @return ShowGenre
     */
    public function getGenre(): ShowGenre
    {
        return $this->genre;
    }


}