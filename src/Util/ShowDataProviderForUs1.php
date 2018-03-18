<?php


namespace App\Util;


use App\Factory\ShowDataFactory;

abstract class ShowDataProviderForUs1
{
    public static function getDataProvider(): ShowDataFactory
    {
        // NICETOHAVE make sure $filename it is not hardcoded (sadly Symfony 4 does not provide an easy way to access that file)
        $filename = dirname(__FILE__) . '/../../assets/inventory_US-1.csv';
        $showDataProvider = new ShowDataCsvDataReader($filename);

        return $showDataProvider;
    }

    public static function getScenario1Json(): String
    {
        // NICETOHAVE make sure $filename it is not hardcoded (sadly Symfony 4 does not provide an easy way to access that file)
        $filename = dirname(__FILE__) . '/../../assets/inventory_US-1_scenario_1.json';
        $content = file_get_contents($filename);

        return $content;
    }

    public static function getScenario2Json(): String
    {
        // NICETOHAVE make sure $filename it is not hardcoded (sadly Symfony 4 does not provide an easy way to access that file)
        $filename = dirname(__FILE__) . '/../../assets/inventory_US-1_scenario_2.json';
        $content = file_get_contents($filename);

        return $content;
    }


    public static function getScenarioWithShowStatusesInThePast(): String
    {
        // NICETOHAVE make sure $filename it is not hardcoded (sadly Symfony 4 does not provide an easy way to access that file)
        $filename = dirname(__FILE__) . '/../../assets/inventory_US-1_test_status_in_the_past.json';
        $content = file_get_contents($filename);

        return $content;
    }
}