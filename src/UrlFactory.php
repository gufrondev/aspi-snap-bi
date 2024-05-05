<?php

namespace GufronDev\AspiSnapBI;

class UrlFactory
{
    /**
     * Creates a URL for the specified provider and endpoint.
     *
     * @param string $provider The provider name.
     * @param string $endpoint The endpoint to append to the URL.
     *
     * @return string The fully constructed URL.
     */
    public static function create($provider, $endpoin)
    {
        return implode('/', [
            config("snapbi.{$provider}.res"),
            config("snapbi.{$provider}.version"),
            $endpoin,
        ]);
    }
}
