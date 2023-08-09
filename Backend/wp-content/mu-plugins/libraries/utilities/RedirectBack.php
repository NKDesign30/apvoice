<?php

namespace awsm\wp\libraries\utilities;

trait RedirectBack 
{   
    /**
     * Redirect back to the http referer the request originated from
     * and attach the given payload as encoded query string.
     *
     * @param  array  $payload
     */
    protected function redirectBack( $payload = [] )
    {
        $url = $_POST['_wp_http_referer'] ?? wp_login_url();
        $url = urldecode( sanitize_text_field( wp_unslash( $url ) ) );

        $segments = preg_split( '/\?/', $url );
        $url = array_shift($segments);

        if ( !empty( $payload ) ) {
            $segments[] = 'payload=' . base64_encode( serialize( $payload ) );
        }

        wp_safe_redirect( $url . '?' . implode( '&', $segments ) );

        exit;
    }
}