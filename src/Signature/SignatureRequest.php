<?php

namespace GufronDev\AspiSnapBI\Signature;

use Exception;
use GufronDev\AspiSnapBI\Requestor;
use GufronDev\AspiSnapBI\UrlFactory;
use GufronDev\AspiSnapBI\HeaderFactory;

class SignatureRequest
{
    protected Requestor $requestor;
    protected $use_proxy;
    protected $timestamp;
    protected $client_key;
    protected $private_key;
    protected $endpoint;
    protected $provider;

    public function __construct(
        $timestamp,
        $client_key,
        $private_key,
        $provider
    ) {
        $this->requestor = new Requestor();
        $this->timestamp = $timestamp;
        $this->client_key = $client_key;
        $this->private_key = $private_key;
        $this->provider = $provider;
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

    /**
     * Request signature from provider
     *
     * @return String
     */
    public function request()
    {
        $endpoint = UrlFactory::create($this->provider, 'utilities/signature-auth');
        $url = config("snapbi.{$this->provider}.url") . '/'. $endpoint;

        $headers = new HeaderFactory(
            timestamp: $this->timestamp,
            clientKey: $this->client_key,
            privateKey: $this->private_key
        );

        $req = $this->requestor
                ->withHeaders($headers->toArray())
                ->post($url);

        if ( !$req->successful() ) {
            return $req->throw();
        }

        $resp = $req->object();

        return $resp->signature;
    }
}
