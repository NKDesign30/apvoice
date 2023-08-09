<?php

namespace apo\pgci\parsers;

use apo\pgci\parsers\contracts\AbstractExpertCodeDocumentParser;
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

            foreach ( ['A', 'B', 'C', 'D', 'E','F'] as $index => $column ) {
                $row[$index] = $excelRow[$column] ?? null;
            }

            if ( $this->validateRow( $row ) ) {
                $result[] = $row;
            }
        }

        return array_map( function ( $row ) {
            return [
                'pg_customer_id' => $row[0],
                'name' => $row[1],
                'bga_id' => $row[2],
                'street' => $row[3],
                'zip' => $row[4],
                'city' => $row[5]
            ];
        }, $result );
    }
}
