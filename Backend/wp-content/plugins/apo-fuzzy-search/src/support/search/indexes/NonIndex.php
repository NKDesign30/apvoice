<?php
namespace apo\fuzzysearch\support\search\indexes;

use apo\fuzzysearch\support\search\contracts\AbstractIndex;
use apo\fuzzysearch\support\search\FileNames;

class NonIndex extends AbstractIndex
{
    /**
    * Creates a new instance of NonIndex
    */
    public function __construct(string $term)
    {
        parent::__construct($term);
    }

    /**
     * Search in the zip code index
     * 
     * @param int $maxResults   The maximum amount of search results
     * @return array
     */
    public function search(int $maxResults = 10)
    {
        $list = $this->read();
        usort($list, function ($a, $b) {
            return levenshtein($this->term, mb_strtolower($a)) <=> levenshtein($this->term, mb_strtolower($b));
        });

        return array_slice($list, 0, $maxResults);
    }

    public function read()
    {
        if (!file_exists(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::PHARMACIES_CSV))  {
            return [];
        }
        
        return array_map(function($row) {
            [$name, $street, $number, $zip, $city] = explode(';', $row);
            return trim("{$name}, {$street} {$number}, {$zip}, {$city}");
        }, file(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::PHARMACIES_CSV));
    }
}
