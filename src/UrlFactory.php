<?php

namespace GufronDev\AspiSnapBI;

class UrlFactory
{
    public static function create($provider, $endpoin)
    {
        return implode('/', [
            config("snapbi.{$provider}.res"),
            config("snapbi.{$provider}.version"),
            $endpoin,
        ]);
    }
}
