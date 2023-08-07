<?php
namespace apo\fuzzysearch\support\search\contracts;

abstract class AbstractIndex
{

    /**
     * The search term
     * 
     * @var string
     */
    protected $term;

    /**
    * Creates a new instance of AbstractIndex
    */
    public function __construct(string $term)
    {
        $this->term = $term;
    }

    /**
     * Search the term in the provided index
     * 
     * @param int $maxResults   The maximum amount of search results
     * 
     * @return array
     */
    abstract public function search(int $maxResults = 10);

    /**
     * Reads the provided index
     * 
     * @return array
     */
    abstract public function read();
}
