<?php


namespace App\Util;


use App\DataView\InventoryItemView;
use App\DataView\InventoryView;
use App\DataView\ShowItemView;
use App\Domain\Inventory;
use App\Domain\ShowGenre;
use App\Factory\ShowDataFactory;

class InventoryViewFactory
{
    protected $showDataProvider;

    public function __construct(ShowDataFactory $showDataProvider)
    {
        $this->showDataProvider = $showDataProvider;
    }

    public function get(\DateTime $queryDate, \DateTime $showDate): InventoryView
    {
        $inventory = new Inventory($this->showDataProvider);
        $inventory->filterAndLeaveOnlyShowsThatHaveShowOnThisDay($showDate);
        $shows = $inventory->getShows();

        // Extract genres
        $genreToShowsMap = [];

        foreach ($shows as $show) {
            $genre = (string)$show->getGenre();

            $genreToShowsMap[$genre] = [];
        }

        // Populate them with shows
        foreach ($shows as $show) {
            $genre = (string)$show->getGenre();
            $showInfo = $show->getShowInfo($showDate, $queryDate);

            $showItem = new ShowItemView(
                $show->getTitle(),
                $showInfo->getTicketsLeft(),
                $showInfo->getTicketsAvailable(),
                $showInfo->getStatus(),
                $showInfo->getPrice()
            );

            $genreToShowsMap[$genre][] = $showItem;
        }

        // Move this data to our output format
        $inventoryView = new InventoryView();

        foreach ($genreToShowsMap as $genre => $shows) {
            $inventoryItem = new InventoryItemView(new ShowGenre($genre));

            foreach ($shows as $show) {
                $inventoryItem->addShow($show);
            }

            $inventoryView->addItem($inventoryItem);
        }

        return $inventoryView;
    }
}