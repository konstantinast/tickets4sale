<?php

namespace App\Domain;

use MyCLabs\Enum\Enum;

class ShowStatus extends Enum
{
    const sale_not_started = 'sale not started';
    const open_for_sale = 'open for sale';
    const sold_out = 'sold out';
    const in_the_past = 'in the past';
}