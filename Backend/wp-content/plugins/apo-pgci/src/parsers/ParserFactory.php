<?php

namespace apo\pgci\parsers;

class ParserFactory
{
    /**
     * Create a concrete instance of a AbstractExpertCodeDocumentParser
     * implementation for the given upload.
     *
     * @param  array  $upload
     * @return apo\pgci\parsers\contracts\AbstractExpertCodeDocumentParser
     */
    public static function makeFromUpload( array $upload )
    {
        switch ( $upload['type'] ) {
            // CSV
            case 'text/csv':
                return new CsvParser( $upload['tmp_name'] );

            // XLS
            case 'application/vnd.ms-excel':
                return new XlsParser( $upload['tmp_name'] );

            // XLSX
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                return new XlsxParser( $upload['tmp_name'] );
        }

        if ( $upload['type'] === 'application/octet-stream' && (bool) preg_match( '/\.xls$/i', $upload['name'] ) ) {
            return new XlsParser( $upload['tmp_name'] );
        }

        return new NoopParser( $upload['tmp_name'] );
    }
}
