<?php

namespace apo\pgci\parsers;

use apo\pgci\parsers\contracts\AbstractExpertCodeDocumentParser;

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
