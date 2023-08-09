<?php
namespace apo\fuzzysearch\support\search;

use apo\fuzzysearch\support\search\FileNames;

class CreateSearchIndex
{

    /**
     * @return array 
     */
    public static function create()
    {
        $wordIndex = [];
        $zipIndex = [];
        foreach (self::read() as $row) {
            $row = preg_replace('/[\x00-\x1F\x7F]/u', '', $row);
            [$firstPart, $secondPart] = preg_split('/;(?=\d)/', $row, 2);
            $record = str_replace(';', ', ',  trim($firstPart . ' ' . $secondPart));

            [$name, $street, $number, $zip, $city] = array_map('trim', explode(';', $row));
            $wordIndex[mb_strtolower($name)][] = $record;
            $wordIndex[mb_strtolower($street)][] = $record;
            $zipIndex[$zip][] = $record;
            $wordIndex[mb_strtolower($city)][] = $record;
        }
    
        $wordIndexResult = (bool) file_put_contents(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::WORD_INDEX, json_encode($wordIndex));
        $zipIndexResult = (bool) file_put_contents(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::ZIP_INDEX, json_encode($zipIndex));
        return [
            'word_index_created' => $wordIndexResult,
            'zip_index_created' => $zipIndexResult,
        ];
    }

    /**
     * @return array
     */
    public static function read()
    {
        if (!file_exists(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::PHARMACIES_CSV))  {
            throw new \Exception('The pharmacies csv file does not exists in ' . APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::PHARMACIES_CSV);
        }
        
        // return array_slice(file(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::PHARMACIES_CSV), 0 ,5);
        return file(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::PHARMACIES_CSV);
    }
}
