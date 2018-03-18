<?php

namespace App\DataView;

use App\Domain\ShowStatus;

class ShowItemView implements \JsonSerializable
{
    private $title;
    private $ticketsLeft;
    private $ticketsAvailable;
    private $status;

    public function __construct(string $title, int $ticketsLeft, int $ticketsAvailable, ShowStatus $status)
    {
        $this->title = $title;
        $this->ticketsLeft = $ticketsLeft;
        $this->ticketsAvailable = $ticketsAvailable;
        $this->status = $status;
    }

    public function jsonSerialize()
    {
        $obj = [
            'title' => (string)strtolower($this->title),
            'tickets left' => (string)$this->ticketsLeft,
            'tickets available' => (string)$this->ticketsAvailable,
            'status' => (string)strtolower($this->status),
        ];

        return $obj;
    }


}