<?php


namespace App\Util;


use App\Factory\ShowDataFactory;
use League\Csv\Reader;

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
        $csvContent = $this->getCsvContent($this->filename);
        $csvReader = Reader::createFromString($csvContent);
        $csvRecords = $csvReader->getIterator();

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

    private function getCsvContent($filename)
    {
        $rawContent = file_get_contents($filename);

        // Lets fix the file content a bit
        $content = preg_replace("/[\r\n]{1,}|[\r]{1,}|[\n]{1,}/", "\n", $rawContent); // hopefully this will be enough

        return $content;
    }

}