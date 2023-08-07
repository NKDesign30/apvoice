<?php

namespace apo\pun\parsers;

use apo\pun\parsers\contracts\AbstractExpertCodeDocumentParser;

class NoopParser extends AbstractExpertCodeDocumentParser
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
