<?php


namespace App\Domain;

/**
 * Show info holder for particular day, when the show is expected to be shown
 */
class ShowInfo
{
    private $title;
    private $status;
    private $ticketsLeft;
    private $ticketsAvailable;
    private $location;

    public function __construct(
        String $title,
        int $ticketsLeft,
        int $ticketsAvailable,
        ShowStatus $status,
        ShowLocation $location
    ) {
        $this->title = strtolower($title);
        $this->ticketsLeft = $ticketsLeft;
        $this->ticketsAvailable = $ticketsAvailable;
        $this->status = $status;
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getTicketsLeft()
    {
        return $this->ticketsLeft;
    }

    /**
     * @return mixed
     */
    public function getTicketsAvailable()
    {
        return $this->ticketsAvailable;
    }

    /**
     * @return ShowLocation
     */
    public function getLocation(): ShowLocation
    {
        return $this->location;
    }


}