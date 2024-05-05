<?php

namespace App\Libraries\AspiSnapBI\Signature;

use App\Libraries\AspiSnapBI\Authorization\AuthToken;
use Exception;

class ServiceSignature
{
    /**
     * Symmetric signature generator
     *
     * @param String $provider
     * @param Int $timestamp
     * @param String $endpoinUrl
     * @param String $httpMethod
     * @param Array $payload
     */
    public static function generate($arguments)
    {
        extract($arguments);
        $is_physical_keys = config("snapbi.{$provider}.is_physical_keys");
        $client_secret = config("snapbi.{$provider}.client_secret");
        $signature = '';

        if ( $is_physical_keys ) {
            $data = [
                $httpMethod,
                $endpoinUrl,
                $authToken,
                hash('sha512', json_encode($payload)),
                $timestamp
            ];
            $data = implode(":", $data);
            $signature = base64_encode(hash_hmac('sha512', $data, $client_secret, true));
        } else {
            $signature = (new SignatureServiceRequest(
                endpoinUrl: $endpoinUrl,
                authToken: $authToken,
                httpMethod: $httpMethod,
                payload: $payload,
                timestamp: $timestamp,
                clientSecret: $client_secret,
                provider: $provider,
            ))->request();
        }

        return $signature;
    }

    /**
     * Symmetric signature verifier
     *
     * @param Array $data
     * @param String $signature
     * @param String $clientSecret
     */
    public static function verify($signature, $arguments)
    {
        extract($arguments);
        return hash_equals($signature, static::generate($provider, $timestamp, $endpoinUrl, $httpMethod, $payload));
    }
}
