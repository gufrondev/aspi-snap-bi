<?php

namespace GufronDev\AspiSnapBI\Signature;

use Exception;
use GufronDev\AspiSnapBI\Requestor;
use GufronDev\AspiSnapBI\UrlFactory;
use GufronDev\AspiSnapBI\HeaderFactory;

class SignatureServiceRequest
{
    protected Requestor $requestor;
    protected $use_proxy;
    protected $endpoint;
    protected $accessToken;

    public function __construct(
        protected $provider,
        protected $endpoinUrl = '',
        protected $authToken = '',
        protected $timestamp = '',
        protected $clientSecret = '',
        protected $httpMethod = '',
        protected $payload = null
    ) {
        $this->requestor = new Requestor();
        $this->provider = $provider;
        $this->timestamp = $timestamp;
        $this->clientSecret = $clientSecret;
        $this->httpMethod = $httpMethod;
        $this->authToken = $authToken;
        $this->payload = $payload;
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
        $endpoint = UrlFactory::create($this->provider, 'utilities/signature-service');
        $url = config("snapbi.{$this->provider}.url") . '/'. $endpoint;

        $headers = new HeaderFactory(
            timestamp: $this->timestamp,
            clientSecret: $this->clientSecret,
            httpMethod: $this->httpMethod,
            endpoinUrl: $this->endpoinUrl,
            accessToken: $this->authToken
        );

        $req = $this->requestor
                ->withHeaders($headers->toArray())
                ->post($url, $this->payload);

        if ( !$req->successful() ) {
            return $req->throw();
        }

        $resp = $req->object();

        return $resp->signature;
    }
}
