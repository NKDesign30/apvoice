<?php
namespace apo\fuzzysearch\support\search\indexes;

use apo\fuzzysearch\support\search\contracts\AbstractIndex;
use apo\fuzzysearch\support\search\FileNames;

class WordIndex extends AbstractIndex
{
    /**
    * Creates a new instance of WordIndex
    */
    public function __construct(string $word)
    {
        parent::__construct($word);
    }

    /**
     * Search in the word code index
     * 
     * @param int $maxResults   The maximum amount of search results
     * 
     * @return array
     */
    public function search(int $maxResults = 10)
    {
        $list = array_filter($this->read(), function($word) {
            return strpos($word, $this->term) === 0;
        }, ARRAY_FILTER_USE_KEY);
    
        $words = array_keys($list);
    
        usort($words, function ($a, $b)  {
            return levenshtein($this->term, $a) <=> levenshtein($this->term, $b);
        });
    
        $wordSlice = array_slice($words, 0, $maxResults);
    
        $result = array_merge(...array_values(array_filter($list, function($key) use ($wordSlice) {
            return in_array($key, $wordSlice);
        }, ARRAY_FILTER_USE_KEY)));
    
        usort($result, function ($a, $b) {
            return levenshtein($this->term, $a) <=> levenshtein($this->term, $b);
        });
    
        return $result;
    }

    public function read()
    {
        if (!file_exists(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::WORD_INDEX))  {
            return [];
        }
        return json_decode(file_get_contents(APO_FUZZY_SEARCH_INDEXES_DIR . FileNames::WORD_INDEX), true);
    }
}
