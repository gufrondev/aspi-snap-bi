<?php

namespace GufronDev\AspiSnapBI\Signature;

use Exception;
use GufronDev\AspiSnapBI\Signature\SignatureRequest;

class TokenSignature
{
    /**
     * Assymetric signature generator
     *
     * @param String $provider
     * @param Int $timestamp
     */
    public static function generate($provider, $timestamp)
    {
        $is_physical_keys = config("snapbi.{$provider}.is_physical_keys");
        $client_key = config("snapbi.{$provider}.client_id");
        $signature = '';

        if ( $is_physical_keys ) {
            $file_path = storage_path(config("snapbi.{$provider}.secret_key"));

            if ( !file_exists($file_path) ) {
                throw new Exception('Secret key not found');
            }
            // get private key from storage using file_get_contents
            $private_key = file_get_contents($file_path);
            // get assymetric key from private key
            $assym_key = openssl_pkey_get_private($private_key);
            if ( !$assym_key ) {
                throw new Exception('Invalid private key: ' . openssl_error_string());
            }
            $client_key = config("snapbi.{$client_key}.client_id");
            $str_sign = "{$client_key}|{$timestamp}";

            openssl_sign($str_sign, $signature, $assym_key, 'RSA-SHA256');

            if ( !$signature ) {
                throw new Exception('Failed to generate signature');
            }

            $signature = base64_encode($signature);
        } else {
            $private_key = config("snapbi.{$provider}.secret_key");
            // get signature from api
            $signature = (new SignatureRequest($timestamp, $client_key, $private_key, $provider))->request();
        }

        return $signature;
    }

    /**
     * Assymetric signature verifier
     *
     * @param String $signature
     * @param String $public_key
     */
    public static function verify($data, $signature, $public_key)
    {
        $assym_key = openssl_pkey_get_public($public_key);

        if ( !$assym_key ) {
            throw new Exception('Invalid public key');
        }

        $signature = base64_decode($signature);

        return openssl_verify($data, $signature, $assym_key, 'RSA-SHA256');;
    }
}
