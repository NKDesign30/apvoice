<?php

namespace apo\bonago\parsers\contracts;

abstract class AbstractVoucherCodeDocumentParser
{
    /**
     * The path to the file to parse.
     *
     * @var string
     */
    protected $filepath;

    /**
     * AbstractVoucherCodeDocumentParser constructor.
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
        return (bool) preg_match( '/voucher|code/i', $row[0] ) === false && (bool) preg_match( '/expires/i', $row[1] ) === false && count( $row ) >= 2;
    }
}
