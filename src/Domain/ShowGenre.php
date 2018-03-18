<?php


namespace App\Domain;


use MyCLabs\Enum\Enum;

class ShowGenre extends Enum
{
    const musical = 'musical';
    const comedy = 'comedy';
    const drama = 'drama';

    public function __construct($value)
    {
        // Making sure we do not care about passed value (probably from csv)
        $updatedValue = strtolower($value);
        parent::__construct($updatedValue);
    }
}