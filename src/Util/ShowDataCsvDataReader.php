<?php


namespace App\Util;


use App\Factory\ShowDataFactory;
use Keboola\Csv\CsvFile;

class ShowDataCsvDataReader extends ShowDataFactory
{
    private $filename;

    /**
     * ShowDataCsvDataReader constructor.
     * @param $filename
     */
    public function __construct(String $filename)
    {
        $this->filename = $filename;
    }


    function getShowsData(): ShowDataIterator
    {
        $csvRecords = new CsvFile($this->filename);
        $showsData = new ShowDataIterator();

        foreach ($csvRecords as $record) {
            $title = $record[0];
            $openingDay = $record[1];
            $genre = $record[2];

            $showDataInstance = new ShowData($title, new \DateTime($openingDay), $genre);

            $showsData->add($showDataInstance);
        }

        return $showsData;
    }

}