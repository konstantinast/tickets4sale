<?php


namespace App\DataView;


use App\Domain\ShowGenre;

class InventoryItemView implements \JsonSerializable
{
    private $genre;
    private $shows;

    public function __construct(ShowGenre $genre)
    {
        $this->genre = $genre;
    }

    public function addShow(ShowItemView $show)
    {
        $this->shows[] = $show;
    }

    public function jsonSerialize()
    {
        $obj = [
            'genre' => (string)strtolower($this->genre),
            'shows' => $this->shows
        ];

        return $obj;
    }
}