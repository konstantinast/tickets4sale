<?php


namespace App\BusinessRules;


use App\Domain\ShowGenre;

class ShowTicketPricing
{
    // Settings
    protected static $genreToPriceMap = [
        ShowGenre::musical => 70,
        ShowGenre::comedy => 50,
        ShowGenre::drama => 40
    ];

    protected $genre;
    protected $price;

    public function __construct(ShowGenre $showGenre)
    {
        $this->genre = $showGenre;
        $this->price = self::$genreToPriceMap[$showGenre->getKey()];
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }
}