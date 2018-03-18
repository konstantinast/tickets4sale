<?php


namespace App\Domain;


use App\Factory\ShowDataFactory;

class Inventory
{
    /** @var Show[] */
    private $shows = [];

    public function __construct(ShowDataFactory $showDataProvider)
    {
        $showsData = $showDataProvider->getShowsData();

        foreach ($showsData as $showData) {
            $title = $showData->getTitle();
            $openingDay = $showData->getOpeningDay();
            $genre = new ShowGenre($showData->getGenre());

            $showInstance = new Show($title, $openingDay, $genre);

            $this->shows[] = $showInstance;
        }
    }

    public function filterAndLeaveOnlyShowsThatHaveShowOnThisDay(\DateTime $showDate)
    {
        $shows = [];

        foreach ($this->shows as $show) {
            if ($show->isItShownOnThisDay($showDate)) {
                $shows[] = $show;
            }
        }

        $this->shows = $shows;
    }

    /**
     * @return Show[]
     */
    public function getShows(): array
    {
        return $this->shows;
    }
}