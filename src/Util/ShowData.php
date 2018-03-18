<?php


namespace App\Util;


class ShowData
{
    private $title;
    private $openingDay;
    private $genre;

    /**
     * ShowData constructor.
     * @param $title
     * @param $openingDay
     * @param $genre
     */
    public function __construct(String $title, \DateTime $openingDay, String $genre)
    {
        $this->title = $title;
        $this->openingDay = $openingDay;
        $this->genre = $genre;
    }

    /**
     * @return String
     */
    public function getTitle(): String
    {
        return $this->title;
    }

    /**
     * @return \DateTime
     */
    public function getOpeningDay(): \DateTime
    {
        return $this->openingDay;
    }

    /**
     * @return String
     */
    public function getGenre(): String
    {
        return $this->genre;
    }
}