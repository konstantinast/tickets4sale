<?php

namespace App\Command;

use App\Util\InventoryViewFactory;
use App\Util\ShowDataCsvDataReader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppGetInventoryCommand extends Command
{
    protected static $defaultName = 'app:get-inventory';
    protected $errorPresent = false;

    protected function configure()
    {
        $this
            ->setDescription('CLI tool that takes in arguments and returns show performance info in a format where shows are grouped by genre.')
            ->addArgument('csv_filename', InputArgument::REQUIRED,
                'Path to csv file containing show data. Column values (show_title, opening_day, genre_of_show).')
            ->addArgument('query_date', InputArgument::REQUIRED,
                'The reference data that determines the inventory state. Format (YYYY-MM-DD) a.k.a ISO 8601.')
            ->addArgument('show_date', InputArgument::REQUIRED,
                'The date for which you want to know how many tickets are left and etc. Format (YYYY-MM-DD) a.k.a ISO 8601.');
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        parent::interact($input, $output);

        $io = new SymfonyStyle($input, $output);

        // $csvFilename = $input->getArgument('csv_filename'); // TODO implement later some simple csv data validation class
        $queryDate = $input->getArgument('query_date');
        $showDate = $input->getArgument('show_date');

        // TODO Move data format to some separate class
        $dateStringFormat = 'YYYY-MM-DD';

        if (!self::validateDate($queryDate, $dateStringFormat)) {
            $io->error('Passed query_date argument does not conform to desired "' . $dateStringFormat . '". Your passed value is "' . $queryDate . '"');
            $this->errorPresent = true;
        }

        if (!self::validateDate($showDate, $dateStringFormat)) {
            $io->error('Passed show_date argument does not conform to desired "' . $dateStringFormat . '". Your passed value is "' . $showDate . '"');
            $this->errorPresent = true;
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->errorPresent) {
            // die(); // is not an option, since the test fails to get output if we just kill script like this
            return;
        }

        $io = new SymfonyStyle($input, $output);

        // Retrieve passed arguments
        $csvFilename = $input->getArgument('csv_filename');
        $queryDateString = $input->getArgument('query_date');
        $showDateString = $input->getArgument('show_date');

        // Lets get data
        $queryDate = new \DateTime($queryDateString);
        $showDate = new \DateTime($showDateString);
        $showDataIterator = new ShowDataCsvDataReader($csvFilename);
        $inventoryViewFactory = new InventoryViewFactory($showDataIterator);
        $inventoryView = $inventoryViewFactory->get($queryDate, $showDate);

        // Convert response to JSON string
        $inventoryViewJson = $inventoryView->serializeToJson();

        // Output to stdout
        $io->writeln($inventoryViewJson);
    }


    private static function validateDate($date, $format = 'Y-m-d')
    {
        if ($format === 'YYYY-MM-DD') {
            $format = 'Y-m-d'; // The php way - http://php.net/manual/en/datetime.createfromformat.php
        }

        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}
