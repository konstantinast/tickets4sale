<?php


namespace App\Tests\BusinessRules;


use App\BusinessRules\ShowTicketPricing;
use App\Domain\ShowGenre;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ShowTicketPricingTest extends TestCase
{
    public function testWhetherDramaPriceIs40()
    {
        $showGenre = new ShowGenre(ShowGenre::drama);
        $showTicketPricing = new ShowTicketPricing($showGenre);
        $price = $showTicketPricing->getPrice();
        $retrievedGenre = $showTicketPricing->getGenre();

        $expectedPrice = 40;
        $expectedGenre = new ShowGenre(ShowGenre::drama);

        $this->assertEquals($expectedPrice, $price);
        $this->assertEquals($expectedGenre, $retrievedGenre);
    }
}