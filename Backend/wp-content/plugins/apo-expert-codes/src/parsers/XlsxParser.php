<?php

namespace apo\expertcodes\parsers;

use apo\expertcodes\parsers\contracts\AbstractExpertCodeDocumentParser;
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

            foreach ( ['A', 'B', 'C', 'D'] as $index => $column ) {
                $row[$index] = $excelRow[$column] ?? null;
            }

            if ( $this->validateRow( $row ) ) {
                $result[] = $row;
            }
        }

        return array_map( function ( $row ) {
            return [
                'expert_code' => $row[0],
                'email' => $row[1],
                'usages' => empty( $row[2] ) ? null : (int) $row[2],
            ];
        }, $result );
    }
}
