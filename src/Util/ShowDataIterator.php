<?php


namespace App\Util;


class ShowDataIterator implements \Iterator
{
    private $array = [];
    private $position = 0;

    public function __construct()
    {
        $this->position = 0;
    }

    public function add(ShowData $showDataItem)
    {
        $this->array[] = $showDataItem;
    }

    public function current(): ShowData
    {
        return $this->array[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->array[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }


}