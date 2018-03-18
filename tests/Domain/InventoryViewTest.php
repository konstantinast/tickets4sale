<?php


namespace App\Tests\Domain;

use App\Util\InventoryViewFactory;
use App\Util\ShowDataProviderForUs1;
use Swaggest\JsonDiff\JsonDiff;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class InventoryViewTest extends TestCase
{
    public function testClientSpecsUS1Scenario1()
    {
        // Test settings
        $queryDate = new \DateTime('2017-01-01');
        $showDate = new \DateTime('2017-07-01');

        // Expectations
        $expectedJson = ShowDataProviderForUs1::getScenario1Json();

        // Run test
        $this->executeTestClientSpecsUS1ScenarioN($queryDate, $showDate, $expectedJson);
    }

    public function testClientSpecsUS1Scenario2()
    {
        // Test settings
        $queryDate = new \DateTime('2017-08-01');
        $showDate = new \DateTime('2017-08-15');

        // Expectations
        $expectedJson = ShowDataProviderForUs1::getScenario2Json();

        // Run test
        $this->executeTestClientSpecsUS1ScenarioN($queryDate, $showDate, $expectedJson);
    }

    public function testClientSpecsUS1WhetherShowStatusesInThePast()
    {
        // Test settings
        $queryDate = new \DateTime('2018-01-01');
        $showDate = new \DateTime('2017-07-01'); // couple of shows should be show during this time

        // Expectations
        $expectedJson = ShowDataProviderForUs1::getScenarioWithShowStatusesInThePast();

        // Run test
        $this->executeTestClientSpecsUS1ScenarioN($queryDate, $showDate, $expectedJson);
    }

    private function executeTestClientSpecsUS1ScenarioN(\DateTime $queryDate, \DateTime $showDate, $expectedJson)
    {
        // Test data
        $showDataIterator = ShowDataProviderForUs1::getDataProvider();
        $inventoryViewFactory = new InventoryViewFactory($showDataIterator);
        $inventoryView = $inventoryViewFactory->get($queryDate, $showDate);

        // Convert response to JSON string
        $inventoryViewJson = $inventoryView->serializeToJson();

        // Compare it with the one, that the client supplied
        $doJsonStringsHoldTheSameData = false;

        $inventoryViewUnserializedObj = json_decode($inventoryViewJson);
        $expectedUnserializedObj = json_decode($expectedJson);

        try {
            $jsonDiff = new JsonDiff(
                $inventoryViewUnserializedObj,
                $expectedUnserializedObj,
                JsonDiff::REARRANGE_ARRAYS
            );

            $howManyDifferences = $jsonDiff->getDiffCnt();

            if ($howManyDifferences === 0) {
                $doJsonStringsHoldTheSameData = true;
            }
        } catch (\Exception $e) {
            $this->assertTrue(false, 'JsonDiff lib failed :(');
            return;
        }

        $this->assertTrue($doJsonStringsHoldTheSameData, 'Compared JSON derived objects do not hold the same data');
    }
}