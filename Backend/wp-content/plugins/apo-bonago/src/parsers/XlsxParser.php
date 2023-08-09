<?php

namespace apo\bonago\parsers;

use apo\bonago\parsers\contracts\AbstractVoucherCodeDocumentParser;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetFactory;

class XlsxParser extends AbstractVoucherCodeDocumentParser
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
                'voucher_code' => $row[0],
                'expires_at' => $row[1],
            ];
        }, $result );
    }
}
