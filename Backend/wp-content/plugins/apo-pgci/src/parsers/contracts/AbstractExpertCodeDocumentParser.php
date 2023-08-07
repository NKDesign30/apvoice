<?php

namespace apo\pgci\parsers\contracts;

abstract class AbstractExpertCodeDocumentParser
{
    /**
     * The path to the file to parse.
     *
     * @var string
     */
    protected $filepath;

    /**
     * AbstractExpertCodeDocumentParser constructor.
     *
     * @param  string  $filepath
     */
    public function __construct( $filepath )
    {
        $this->filepath = $filepath;
    }

    /**
     * Parse the file.
     *
     * @return array
     */
    abstract public function parse();

    /**
     * Validate the given row.
     *
     * @param  array  $row
     *
     * @return bool
     */
    protected function validateRow( array $row )
    {
        return (bool) preg_match( '/pgci|cif/i', $row[0] ) === false && (bool) preg_match( '/name/i', $row[1] ) === false && count( $row ) >= 2;
    }
}
