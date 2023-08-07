<?php

namespace apo\expertcodes\parsers;

use apo\expertcodes\parsers\contracts\AbstractExpertCodeDocumentParser;

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
