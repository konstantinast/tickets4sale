<?php


namespace App\Tests\Util;


use App\Util\ShowDataProviderForUs1;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ShowDataIteratorTest extends TestCase
{
    public function testShowDataIteratorKeyMethod()
    {
        $showDataFactory = ShowDataProviderForUs1::getDataProvider();
        $showDataIterator = $showDataFactory->getShowsData();

        $expectedKey = 1;

        // Skip one record
        $showDataIterator->next();
        $key = $showDataIterator->key();

        $this->assertSame($expectedKey, $key);
    }
}