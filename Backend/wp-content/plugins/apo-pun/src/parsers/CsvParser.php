<?php

namespace apo\pun\parsers;

use apo\pun\parsers\contracts\AbstractExpertCodeDocumentParser;

class CsvParser extends AbstractExpertCodeDocumentParser
{
    /**
     * Parse the file.
     *
     * @return array
     */
    public function parse()
    {
        $result = [];
        $fp = fopen($this->filepath, 'r');

        while (($row = fgetcsv($fp, 0, ',')) !== false) {
            if ($this->validateRow($row)) {
                $result[] = [
                    'pharmacy_unique_number' => $row[0],
                    'name' => $row[1],
                    'role_id' => $row[2]  // Hinzufügen der Rolle zum resultierenden Array
                ];
            }
        }
        fclose($fp);

        return $result;
    }

    /**
     * Determine the used field delimiter by peaking into the first row
     * and finding a reasonable result.
     *
     * @return string
     */
    protected function determineDelimiter()
    {
        $possibleDelimiters = [','];

        if (($fp = fopen($this->filepath, 'r')) !== false) {
            // Try all delimiters and return the first returning a solid result
            foreach ($possibleDelimiters as $delimiter) {
                $firstRow = fgetcsv($fp, 0, $delimiter);

                // If the result returned for that delimiter contains more than one single row, that must be it then
                if (count($firstRow) > 1) {
                    fclose($fp);

                    return $delimiter;
                }
            }

            fclose($fp);
        }

        return ',';
    }
}
