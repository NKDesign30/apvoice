<?php

namespace apo\pgci\parsers;

use apo\pgci\parsers\contracts\AbstractExpertCodeDocumentParser;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetFactory;

class XlsParser extends XlsxParser
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

            foreach ( ['A', 'B', 'C', 'D', 'E','F','G'] as $index => $column ) {
                $row[$index] = $excelRow[$column] ?? null;
            }

            if ( $this->validateRow( $row ) ) {
                $result[] = $row;
            }
        }
    
        return array_map( function ( $row ) {
            if(count($row)==6){
                return [
                    'bga_id' => $row[0],
                    'name' => $row[1],
                    'house_nr' => $row[2],
                    'street' => $row[3],
                    'zip_code' => $row[4],
                    'city' => $row[5]
                ];
            }else{
                return [
                    'id'=> $row[0],
                    'bga_id' => $row[1],
                    'name' => $row[2],
                    'house_nr' => $row[3],
                    'street' => $row[4],
                    'zip_code' => $row[5],
                    'city' => $row[6]
                ]; 
            }
           


        }, $result );
    }
}
