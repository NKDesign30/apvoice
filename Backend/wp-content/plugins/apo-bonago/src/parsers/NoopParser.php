<?php

namespace apo\bonago\parsers;

use apo\bonago\parsers\contracts\AbstractVoucherCodeDocumentParser;

class NoopParser extends AbstractVoucherCodeDocumentParser
{
    /**
     * Parse the file.
     *
     * @return array
     */
    public function parse()
    {
        return [];
    }
}
