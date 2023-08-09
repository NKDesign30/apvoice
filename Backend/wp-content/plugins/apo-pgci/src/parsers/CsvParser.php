<?php

namespace apo\pgci\parsers;

use apo\pgci\parsers\contracts\AbstractExpertCodeDocumentParser;

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
        $fp = fopen( $this->filepath, 'r' );

        while ( ( $row = fgetcsv( $fp, 0, ';' ) ) !== false ) {
            $formattedRows = [];
            $getValuesFromCsv = array_filter(explode(',', $row[0]));

            foreach ($getValuesFromCsv as $row) {
                array_push($formattedRows, $this->formatRow($row));
            }

            $result[] = [
                'bga_id' => $formattedRows[1],
                'street' => $formattedRows[2],
                'name' => $formattedRows[3],
                'house_nr' => $formattedRows[4],
                'zip_code' => $formattedRows[5],
                'city' => $formattedRows[6],
            ];
        }

        fclose( $fp );

        return $result;
    }

    protected function formatRow($row)
    {
        return trim(trim($row, '"'), ' ');
    }

    /**
     * Determine the used field delimiter by peaking into the first row
     * and finding a reasonable result.
     *
     * @return string
     */
    protected function determineDelimiter()
    {
        $possibleDelimiters = [',', ';', '|'];

        if ( ($fp = fopen( $this->filepath, 'r' )) !== false ) {
            // Try all delimiters and return the first returning a solid result
            foreach ( $possibleDelimiters as $delimiter ) {
                $firstRow = fgetcsv( $fp, 0, $delimiter );

                // If the result returned for that delimiter contains more than one single row, that must be it then
                if ( count( $firstRow ) > 1 ) {
                    fclose( $fp );

                    return $delimiter;
                }
            }

            fclose( $fp );
        }

        return ',';
    }
}
