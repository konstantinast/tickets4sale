<?php


namespace App\BusinessRules;


class ShowDiscountDetails
{
    protected $discount;

    public function __construct(int $whichShowDay)
    {
        if ($whichShowDay > 80) {
            $this->discount = 20; // percent
        } else {
            $this->discount = 0; // no discount
        }
    }

    /**
     * @return int
     */
    public function getDiscount(): int
    {
        return $this->discount;
    }
}