<?php


namespace App\Factory;


use App\Util\ShowDataIterator;

abstract class ShowDataFactory
{
    abstract function getShowsData(): ShowDataIterator;
}