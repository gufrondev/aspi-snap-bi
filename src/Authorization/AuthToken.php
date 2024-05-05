<?php

namespace App\Libraries\AspiSnapBI\Authorization;

use Exception;
use Illuminate\Support\Facades\Cache;
use App\Libraries\AspiSnapBI\Requestor;
use App\Libraries\AspiSnapBI\UrlFactory;
use App\Libraries\AspiSnapBI\HeaderFactory;
use App\Libraries\AspiSnapBI\Signature\TokenSignature;

class AuthToken
{
    protected $enpoint;
    protected $provider;
    protected $timestamp;
    protected Requestor $requestor;
    protected $use_proxy;

    public function __construct($timestamp, $provider)
    {
        $this->requestor = new Requestor();
        $this->provider = $provider;
        $this->timestamp = $timestamp;
        $this->use_proxy = config("snapbi.{$this->provider}.use_proxy");

        if ( $this->use_proxy ) {
            $ip = config("snapbi.{$this->provider}.proxy_ip");
            $port = config("snapbi.{$this->provider}.proxy_port");
            $username = config("snapbi.{$this->provider}.proxy_username");
            $password = urlencode(config("snapbi.{$this->provider}.proxy_password"));

            $this->requestor->mergeOptions(
                ['proxy' => "http://{$username}:{$password}@{$ip}:{$port}"]
            );
        }
    }

    public function get()
    {
        $cacheName = "snapbi.{$this->provider}.access_token";

        if ( !Cache::has($cacheName) ) {
            return $this->request();
        }

        return Cache::get($cacheName);
    }

    public function request()
    {
        $enpoint = UrlFactory::create($this->provider, 'access-token/b2b');
        $url = config("snapbi.{$this->provider}.url") . '/' . $enpoint;
        $client_key = config("snapbi.{$this->provider}.client_id");

        $signature = TokenSignature::generate($this->provider, $this->timestamp);

        $headers = new HeaderFactory(
            timestamp: $this->timestamp,
            clientKey: $client_key,
            signature: $signature
        );

        $req = $this->requestor
            ->withHeaders($headers->toArray())
            ->post($url, [
                'grantType' => 'client_credentials'
            ]);

        if ( !$req->successful() ) {
            return $req->throw();
        }

        $resp = $req->object();

        // store access token to cache
        Cache::put("snapbi.{$this->provider}.access_token", $resp->accessToken, $resp->expiresIn);

        return $resp->accessToken;
    }
}
