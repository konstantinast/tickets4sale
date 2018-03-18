<?php

namespace App\DataView;

use App\Domain\ShowStatus;

class ShowItemView implements \JsonSerializable
{
    private $title;
    private $ticketsLeft;
    private $ticketsAvailable;
    private $status;
    private $price;

    public function __construct(
        string $title,
        int $ticketsLeft,
        int $ticketsAvailable,
        ShowStatus $status,
        float $price
    )
    {
        $this->title = $title;
        $this->ticketsLeft = $ticketsLeft;
        $this->ticketsAvailable = $ticketsAvailable;
        $this->status = $status;
        $this->price = $price;
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

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getTicketsLeft(): int
    {
        return $this->ticketsLeft;
    }

    /**
     * @return int
     */
    public function getTicketsAvailable(): int
    {
        return $this->ticketsAvailable;
    }

    /**
     * @return ShowStatus
     */
    public function getStatus(): ShowStatus
    {
        return $this->status;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }


}