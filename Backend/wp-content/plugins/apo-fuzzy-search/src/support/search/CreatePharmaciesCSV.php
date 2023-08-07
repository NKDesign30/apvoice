<?php
namespace apo\fuzzysearch\support\search;

use apo\fuzzysearch\support\search\FileNames;

class CreatePharmaciesCSV
{
    
    /**
     * @return bool
     */
    public static function create()
    {
        $list = array_map(function($row) {
            return array_map('trim', str_getcsv($row, ';'));
        }, self::read());
        
        $fp = fopen(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::PHARMACIES_CSV, 'w');
        foreach ($list as $row) {
            [$name, $streetWithNumber, $zip, $city] = $row;
        
            // split at first digit
            [$street, $number] = preg_split('/(?=\d)/', $streetWithNumber, 2);
        
            $fields = array_map('trim', [$name, $street, $number, $zip, $city]);
    
            fputcsv($fp, $fields, ';', chr(127));
        }
        
        return fclose($fp);
    }

    /**
     * @return array
     */
    public static function read()
    {
        if (!file_exists(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::CSV_WITH_COMBINED_STREET_AND_NUMBER))  {
            throw new \Exception('The original csv file does not exists in ' . APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::CSV_WITH_COMBINED_STREET_AND_NUMBER);
        }
        
        return file(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::CSV_WITH_COMBINED_STREET_AND_NUMBER);
    }   
}
