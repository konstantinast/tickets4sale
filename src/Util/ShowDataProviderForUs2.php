<?php


namespace App\Util;


use App\Factory\ShowDataFactory;

abstract class ShowDataProviderForUs2
{
    public static function getDataProvider(): ShowDataFactory
    {
        // NICETOHAVE make sure $filename it is not hardcoded (sadly Symfony 4 does not provide an easy way to access that file)
        $filename = dirname(__FILE__) . '/../../assets/shows.csv';

        $showDataProvider = new ShowDataCsvDataReader($filename);

        return $showDataProvider;
    }
}