<?php
namespace apo\fuzzysearch\support\search\indexes;

use apo\fuzzysearch\support\search\contracts\AbstractIndex;
use apo\fuzzysearch\support\search\FileNames;

class ZipIndex extends AbstractIndex
{
    /**
    * Creates a new instance of ZipIndex
    */
    public function __construct(string $zip)
    {
        parent::__construct($zip);
    }

    /**
     * Search in the zip code index
     * 
     * @param int $maxResults   The maximum amount of search results
     * @return array
     */
    public function search(int $maxResults = 10)
    {
        $list = array_filter($this->read(), function($zipCode) {
            return strpos($zipCode, $this->term) === 0;
        }, ARRAY_FILTER_USE_KEY);
    
        $zipCodes = array_keys($list);
    
        usort($zipCodes, function ($a, $b) {
            return levenshtein($this->term, $a) <=> levenshtein($this->term, $b);
        });
    
        $zipCodeSlice = array_slice($zipCodes, 0, $maxResults);

        return array_merge(...array_values(array_filter($list, function($key) use($zipCodeSlice ) {
            return in_array($key, $zipCodeSlice);
        }, ARRAY_FILTER_USE_KEY)));
    }

    public function read()
    {
        if (!file_exists(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::ZIP_INDEX))  {
            return [];
        }
        return json_decode(file_get_contents(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::ZIP_INDEX), true);
    }
}
