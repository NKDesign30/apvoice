<?php
namespace apo\fuzzysearch\support\search;
use apo\fuzzysearch\support\search\indexes\NonIndex;
use apo\fuzzysearch\support\search\indexes\ZipIndex;
use apo\fuzzysearch\support\search\indexes\WordIndex;

class FuzzySearch
{

    /**
     * The search string
     * @var string
     */
    protected $s;

    /**
     * The splitted serach strings
     * @var array
     */
    protected $searchTerms;

    /**
     * The first seach term 
     * @var string
     */
    protected $searchTerm;

    /**
    * Creates a new instance of FuzzySearch
    */
    public function __construct(string $s)
    {
        $this->s = mb_strtolower($s);
        $this->createSeachTerms();
    }

    /**
     * Searches in the indexes for the search term
     * 
     * @return array
     */
    public function search()
    {
        if(empty($this->searchTerm) || is_null($this->searchTerm)) {
            return [];
        }

        $indexResult = ctype_digit($this->searchTerm) ? $this->searchInZipIndex() : $this->searchInWordIndex();

        // if there are only one search term, return the first index result
        if (!empty($indexResult) && sizeof($this->searchTerms) === 1) {
           return $indexResult;

        // if there are more then one search terms, refine the search by the given index result
        } else if (!empty($indexResult) && sizeof($this->searchTerms) > 1) {
            return $this->refineSearch($indexResult);

        // if the search term is not indexed, run a non index search by the levenshtein-difference algorithm
        } else {
           return $this->nonIndexSearch();
        }
    }

    /**
     * @return FuzzySearch
     */
    protected function createSeachTerms()
    {
        $this->searchTerms = explode(' ', str_replace(',', '', $this->s));
        $this->searchTerm = $this->searchTerms[0] ?? null;

        return $this;
    }

    protected function searchInZipIndex()
    {
        return (new ZipIndex($this->searchTerm))->search();
    }

    protected function searchInWordIndex()
    {
        return (new WordIndex($this->searchTerm))->search();
    }

    protected function nonIndexSearch()
    {
        return (new NonIndex($this->searchTerm))->search();
    }

    /**
     * @param array $searchResults
     * @return array
     */
    protected function refineSearch(array $serachResults)
    {
        // get rid of the first word
        array_shift($this->searchTerms);
        return array_values(array_filter($serachResults, function($row) {
            $pattern = implode('|', $this->searchTerms);
            preg_match_all("/{$pattern}/i", $row, $matches);
            return sizeof($matches[0]) > 0;
        }));
    }
}
