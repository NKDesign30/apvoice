<?php


function hsso_create_jwt_token($user) {

    $iat          = time();
    $exp          = time() + 3600;

    // Create the token header
    $header = json_encode([
        'alg' => 'HS256',
        'typ' => 'JWT'
    ]);

    // Create the token payload
    $payload = json_encode([
        'sub' => $user->ID,
        'name' => $user->user_login,
        'iat' => $iat,
        'exp' => $exp
    ]);

    // Encode Header
    $base64UrlHeader = hsso_authentication_base64UrlEncode($header);

    // Encode Payload
    $base64UrlPayload = hsso_authentication_base64UrlEncode($payload);

    // Create Signature Hash
   // $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $client_secret, true);

    // Encode Signature to Base64Url String
    //$base64UrlSignature = mo_api_authentication_base64UrlEncode($signature);

    // Create JWT
    $jwt = $base64UrlHeader . "." . $base64UrlPayload;

    $token_data = array(
        'token_type' => 'Bearer',
        'iat' => $iat,
        'expires_in' => $exp,
        'jwt_token' => $jwt,
    );

    return ($token_data);

}

function hsso_authentication_base64UrlEncode($text)
{
    return rtrim(strtr(base64_encode($text), '+/', '-_'), '=');
}

