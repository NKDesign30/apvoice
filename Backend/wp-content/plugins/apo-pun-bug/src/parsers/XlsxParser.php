<?php

namespace apo\pun\parsers;

use apo\pun\parsers\contracts\AbstractExpertCodeDocumentParser;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetFactory;

class XlsxParser extends AbstractExpertCodeDocumentParser
{
    /**
     * Parse the file.
     *
     * @return array
     */
    public function parse()
    {
        $spreadsheet = SpreadsheetFactory::load( $this->filepath );
        $data = $spreadsheet->getActiveSheet()->toArray( null, true, true, true );
        $result = [];

        foreach ( $data as $excelRow ) {
            $row = [];

            foreach ( ['A', 'B'] as $index => $column ) {
                $row[$index] = $excelRow[$column] ?? null;
            }

            if ( $this->validateRow( $row ) ) {
                $result[] = $row;
            }
        }

        return array_map( function ( $row ) {
            return [
                'pharmacy_unique_number' => $row[0],
                'name' => $row[1],
            ];
        }, $result );
    }
}
