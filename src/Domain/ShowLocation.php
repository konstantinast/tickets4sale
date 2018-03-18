<?php


namespace App\Domain;

use MyCLabs\Enum\Enum;

class ShowLocation extends Enum
{
    const big_hall = 'big_hall';
    const small_hall = 'small_hall';
    const unknown = 'unknown';
}