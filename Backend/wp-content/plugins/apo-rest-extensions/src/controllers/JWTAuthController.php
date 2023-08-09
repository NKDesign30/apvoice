<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use Exception;
use \Firebase\JWT\JWT;
use \WP_Error;

class JWTAuthController extends Controller
{

    protected $secretKey;

	public function __construct()
	{
        parent::__construct();
        $this->secretKey = defined('JWT_AUTH_SECRET_KEY') ? JWT_AUTH_SECRET_KEY : false;
	}

	public function pidLogin( Request $request )
    {
        try {
            $token = $request->get_param('token');
            $this->validateTokenPingId($token);

            // get user
            $decodedToken = JWT::decode($token, $this->secretKey, array('HS256'));
            $user = get_userdata($decodedToken->data->user->id);

            return $this->generateTokenPingId($user, true);
        } catch (Exception $e) {
            return [
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
                'line' => $e->getLine()
            ];

            /** Something is wrong trying to decode the token, send back the error */
            return new WP_Error(
                'jwt_auth_invalid_token',
                $e->getMessage(),
                array(
                    'status' => 403
                )
            );
        }
    }

    public function refresh( Request $request )
    {
        try {
            $this->validateToken();

            return $this->generateToken(true);
        } catch (Exception $e) {
            /** Something is wrong trying to decode the token, send back the error */
            return new WP_Error(
                'jwt_auth_invalid_token',
                $e->getMessage(),
                array(
                    'status' => 403,
                )
            );
        }
    }

    protected function generateTokenPingId($user, $mobile = false)
    {
        /** First thing, check the secret key if not exist return a error*/
        if (!$this->secretKey) {
            return new WP_Error(
                'jwt_auth_bad_config',
                __('JWT is not configurated properly, please contact the admin', 'wp-api-jwt-auth'),
                array(
                    'status' => 403,
                )
            );
        }

        /** If the authentication fails return a error*/
        if (is_wp_error($user)) {
            $error_code = $user->get_error_code();
            return new WP_Error(
                '[jwt_auth] ' . $error_code,
                $user->get_error_message($error_code),
                array(
                    'status' => 403,
                )
            );
        }

        /** Valid credentials, the user exists create the according Token */
        $issuedAt = time();
        $notBefore = $issuedAt;
        $expire = $issuedAt + (60 * 30);
        if ($mobile) {
            $expire = $issuedAt + (1825*24*60*60);
        }

        $token = array(
            'iss' => get_bloginfo('url'),
            'iat' => $issuedAt,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => array(
                'user' => array(
                    'id' => $user->data->ID,
                    'pass' => $user->data->user_pass
                ),
            ),
        );

        /** Let the user modify the token data before the sign. */
        $token = JWT::encode($token, $this->secretKey);

        $data = array(
            'token' => $token,
            'user_email' => $user->data->user_email,
            'user_nicename' => $user->data->user_nicename,
            'user_display_name' => $user->data->display_name,
        );

        return apply_filters('jwt_auth_token_before_dispatch', $data, $user);
    }

    protected function generateToken($mobile = false)
    {
        /** First thing, check the secret key if not exist return a error*/
        if (!$this->secretKey) {
            return new WP_Error(
                'jwt_auth_bad_config',
                __('JWT is not configurated properly, please contact the admin', 'wp-api-jwt-auth'),
                array(
                    'status' => 403,
                )
            );
        }

        $user = wp_get_current_user();

        /** If the authentication fails return a error*/
        if (is_wp_error($user)) {
            $error_code = $user->get_error_code();
            return new WP_Error(
                '[jwt_auth] ' . $error_code,
                $user->get_error_message($error_code),
                array(
                    'status' => 403,
                )
            );
        }

        /** Valid credentials, the user exists create the according Token */
        $issuedAt = time();
        $notBefore = $issuedAt;
        $expire = $issuedAt + (60 * 30);
        if ($mobile) {
            $expire = $issuedAt + (1825*24*60*60);
        }

        $token = array(
            'iss' => get_bloginfo('url'),
            'iat' => $issuedAt,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => array(
                'user' => array(
                    'id' => $user->data->ID,
                    'pass' => $user->data->user_pass
                ),
            ),
        );

        /** Let the user modify the token data before the sign. */
        $token = JWT::encode($token, $this->secretKey);

        return ['token' => $token];
    }

    protected function validateToken()
    {
        /*
         * Looking for the HTTP_AUTHORIZATION header, if not present just
         * return the user.
         */
        $auth = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : false;

        /* Double check for different auth header string (server dependent) */
        if (!$auth) {
            $auth = isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) ? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] : false;
        }

        if (!$auth) {
            throw new Exception(
                new WP_Error(
                    'jwt_auth_no_auth_header',
                    'Authorization header not found.',
                    array( 'status' => 403 )
                )
            );
        }

        /*
         * The HTTP_AUTHORIZATION is present verify the format
         * if the format is wrong return the user.
         */
        list($token) = sscanf($auth, 'Bearer %s');
        if (!$token) {
            return new WP_Error(
                'jwt_auth_bad_auth_header',
                'Authorization header malformed.',
                array(
                    'status' => 403,
                )
            );
        }


        /** Get the Secret Key */
        if (!$this->secretKey) {
            throw new Exception(
                new WP_Error(
                    'jwt_auth_bad_config',
                    'JWT is not configurated properly, please contact the admin',
                    array( 'status' => 403 )
                )
            );
        }

        $token = JWT::decode($token, $this->secretKey, array('HS256'));
        /** The Token is decoded now validate the iss */
        if ($token->iss != get_bloginfo('url')) {
            /** The iss do not match, return error */
            throw new Exception(
                new WP_Error(
                    'jwt_auth_bad_iss',
                    'The iss do not match with this server',
                    array( 'status' => 403 )
                )
            );
        }

        /** So far so good, validate the user id in the token */
        if (!isset($token->data->user->id)) {
            /** No user id in the token, abort!! */
            throw new Exception(
                new WP_Error(
                    'jwt_auth_bad_request',
                    'User ID not found in the token',
                    array( 'status' => 403 )
                )
            );
        }

        $user = get_userdata($token->data->user->id);

        /** So far so good, validate the user id in the token */
        if (!isset($token->data->user->pass) ||
            $token->data->user->pass != $user->data->user_pass) {
            /** No user id in the token, abort!! */

            throw new Exception('User Pass not found in the token or is invalid');
        }

        return true;
    }

    protected function validateTokenPingId($token)
    {
        /*
         * The HTTP_AUTHORIZATION is present verify the format
         * if the format is wrong return the user.
         */
        if (!$token) {
            return new WP_Error(
                'jwt_auth_bad_auth_header',
                'Authorization header malformed.',
                array(
                    'status' => 403,
                )
            );
        }


        /** Get the Secret Key */
        if (!$this->secretKey) {
            throw new Exception(
                new WP_Error(
                    'jwt_auth_bad_config',
                    'JWT is not configurated properly, please contact the admin',
                    array( 'status' => 403 )
                )
            );
        }

        $token = JWT::decode($token, $this->secretKey, array('HS256'));
        /** The Token is decoded now validate the iss */
        if ($token->iss != get_bloginfo('url') && $token->iss != 'https://backend.apovoice.es') {
            /** The iss do not match, return error */
            throw new Exception(
                new WP_Error(
                    'jwt_auth_bad_iss',
                    'The iss do not match with this server',
                array( 'status' => 403 )
                )
            );
        }

        /** So far so good, validate the user id in the token */
        if (!isset($token->data->user->id)) {
            /** No user id in the token, abort!! */
            throw new Exception(
                new WP_Error(
                    'jwt_auth_bad_request',
                    'User ID not found in the token',
                    array( 'status' => 403 )
                )
            );
        }

        $user = get_userdata($token->data->user->id);

        /** So far so good, validate the user id in the token */
        if (!isset($token->data->user->pass) ||
            $token->data->user->pass != $user->data->user_pass) {
            /** No user id in the token, abort!! */

            throw new Exception('User Pass not found in the token or is invalid');
        }
            
        return true;
    }
}
