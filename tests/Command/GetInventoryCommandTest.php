<?php


namespace App\Tests\Command;

use App\Util\ShowDataProviderForUs1;
use Swaggest\JsonDiff\JsonDiff;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GetInventoryCommandTest extends KernelTestCase
{
    public function testExecuteWithUS1Scenario1Data()
    {
        $queryDateString = "2017-01-01";
        $showDateString = "2017-07-01";

        $expectedJson = ShowDataProviderForUs1::getScenario1Json();

        $this->executeTestExecuteWithUS1ScenarioNData($queryDateString, $showDateString, $expectedJson);
    }

    public function testExecuteWithUS1Scenario2Data()
    {
        $queryDateString = "2017-08-01";
        $showDateString = "2017-08-15";

        $expectedJson = ShowDataProviderForUs1::getScenario2Json();

        $this->executeTestExecuteWithUS1ScenarioNData($queryDateString, $showDateString, $expectedJson);
    }

    public function testExecuteHandlesWrongDataFormatsInInteractionPhase()
    {
        // el gringos
        $wrongFormatQueryDateString = 'August 01, 2017';
        $wrongFormatShowDateString = 'August 15, 2017';

        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);

        $command = $application->find('app:get-inventory');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'command' => $command->getName(),
                'csv_filename' => "assets/inventory_US-1.csv",
                'query_date' => $wrongFormatQueryDateString,
                'show_date' => $wrongFormatShowDateString
            ],
            [
                'interactive' => true,
            ]
        );

        $output = $commandTester->getDisplay();

        $this->assertContains(
            'error',
            $output,
            'Wrong date format passed and error message was not displayed',
            true
        );
    }

    private function executeTestExecuteWithUS1ScenarioNData(
        string $queryDateString,
        string $showDateString,
        string $expectedJson
    ) {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);

        $command = $application->find('app:get-inventory');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'csv_filename' => "assets/inventory_US-1.csv",
            'query_date' => $queryDateString,
            'show_date' => $showDateString
        ]);

        $outputJson = $commandTester->getDisplay();
        $doJsonStringsHoldTheSameData = false;

        // Test
        $outputUnserializedObj = json_decode($outputJson);
        $expectedUnserializedObj = json_decode($expectedJson);

        try {
            $jsonDiff = new JsonDiff(
                $outputUnserializedObj,
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