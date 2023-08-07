<?php

namespace awsm\wp\libraries\utilities;

trait UploadUtils 
{   

    /**
     * Validate the uploaded file from the request.
     *
     * @return string|bool
     */
    protected function validateUploadedFile()
    {
        $allowedMimeTypes = [
            'text/csv', // CSV
            'application/vnd.ms-excel', // MS Excel (.xls)
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // MS Excel (.xlsx)
        ];

        // Check if file has been uploaded
        if ( !isset( $_FILES ) || !is_array( $_FILES ) || empty( $_FILES ) ) {
            return __( 'No file has been uploaded.', 'awsm_lib' );
        }

        $file = $_FILES[$this->file] ?? false;

        
        // Check if file has been uploaded
        if ( !$file || !is_array( $file ) || empty( $file ) ) {
            return __( 'No file has been uploaded.', 'awsm_lib' );
        }
        
        // Validate allowed mime types
        if ( !in_array( $file['type'], $allowedMimeTypes ) ) {
            // In case of .xls files sometimes the mime type of the file is "application-octet-stream", which
            // could be any binary file. We double check against the file extension to make sure it is an excel file.
            if ( $file['type'] === 'application/octet-stream' && (bool) preg_match( '/\.xls$/i', $file['name'] ) === false ) {
                return __( 'Files of type "' . $file['type'] . '" are not supported. Allowed formats are CSV, XLS and XLSX.', 'awsm_lib' );
            }
        }
        
        // upload_is_file_too_big returns an error message if the file is too big, otherwise the array we just passed. How stupid...
        if ( is_string( upload_is_file_too_big( ['bits' => $file['size']] ) ) ) {
            return __( sprintf( 'The uploaded file is too big. Only files up to %s are allowed', $this->formatBytes( $this->parseSize( get_site_option( 'fileupload_maxk', 1500 ) . 'K' ) ) ), 'awsm_lib' );
        }
        
        // Validate against all possible PHP upload errors and return an appropriate error message
        switch ( $file['error'] ) {
            case UPLOAD_ERR_INI_SIZE:
                return __( sprintf( 'The uploaded file is too big. Only files up to %s are allowed', $this->formatBytes( $this->getMaximumUploadSizeInBytes() ) ), 'awsm_lib' );

            case UPLOAD_ERR_PARTIAL:
                return __( 'The file was only partially uploaded. Please check your connection and try again.', 'awsm_lib' );

            case UPLOAD_ERR_NO_FILE:
                return __( 'No file has been uploaded.', 'awsm_lib' );

            case UPLOAD_ERR_NO_TMP_DIR:
                return __( 'The upload failed because of a configuration problem on the server. Please contact an administrator.', 'awsm_lib' );

            case UPLOAD_ERR_CANT_WRITE:
                return __( 'The upload failed because it could not be stored on the server. Please contact an administrator.', 'awsm_lib' );

            case UPLOAD_ERR_EXTENSION:
                return __( 'The upload failed because of a server error. Please contact an administrator.', 'awsm_lib' );

            case UPLOAD_ERR_OK:
                return true;
        }
    }

    /**
     * Get the maximum possible upload size for a file in bytes.
     *
     * @return int
     */
    protected function getMaximumUploadSizeInBytes()
    {
        static $maxSize = -1;

        if ( $maxSize < 0 ) {
            $postMaxSize = $this->parseSize( ini_get( 'post_max_size' ) );

            if ($postMaxSize > 0) {
                $maxSize = $postMaxSize;
            }

            $uploadMaxSize = $this->parseSize( ini_get( 'upload_max_filesize' ) );

            if ( $uploadMaxSize > 0 && $uploadMaxSize < $maxSize ) {
                $maxSize = $uploadMaxSize;
            }

            $wordpressMaxSize = $this->parseSize( get_site_option( 'fileupload_maxk', 1500 ) . 'K' );

            if ( $maxSize > $wordpressMaxSize ) {
                $maxSize = $wordpressMaxSize;
            }
        }

        return $maxSize;
    }

    /**
     * Parse the given file size string into a number representation.
     *
     * @param  string  $size
     *
     * @return float
     */
    protected function parseSize( $size )
    {
        $unit = preg_replace( '/[^bkmgtpezy]/i', '', $size );
        $size = preg_replace( '/[^0-9\.]/', '', $size );

        if ( $unit ) {
            return round( $size * pow( 1024, stripos( 'bkmgtpezy', $unit[0] ) ) );
        }

        return round( $size );
    }

    /**
     * Format the given bytes to a more reasonable size dimension.
     *
     * @param  int  $bytes
     * @param  int  $precision
     *
     * @return string
     */
    protected function formatBytes( $bytes, $precision = 2 )
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max( $bytes, 0 );
        $pow = floor( ( $bytes ? log( $bytes ) : 0 ) / log( 1024 ) );
        $pow = min( $pow, count( $units ) - 1 );
        $bytes /= pow( 1024, $pow );

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}