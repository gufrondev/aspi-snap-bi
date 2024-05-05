<?php

namespace GufronDev\AspiSnapBI\Services;

use GufronDev\AspiSnapBI\Requestor;
use GufronDev\AspiSnapBI\UrlFactory;
use GufronDev\AspiSnapBI\HeaderFactory;
use GufronDev\AspiSnapBI\Authorization\AuthToken;
use GufronDev\AspiSnapBI\Signature\ServiceSignature;

class AccountInquiry
{
    protected Requestor $requestor;
    protected $timestamp;
    protected $provider;
    protected $use_proxy;
    protected $authToken;

    public function __construct($provider)
    {
        $this->requestor = new Requestor();
        $this->timestamp = date(DATE_ATOM, time());
        $this->provider = $provider;

        $this->use_proxy = config("snapbi.{$this->provider}.use_proxy");
        $this->authToken = new AuthToken($this->timestamp, $this->provider);

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
     * Execute an external account inquiry request.
     *
     * @param array $data The payload data for the request.
     *
     * @return mixed The response object from the API.
     * @throws \Exception If the request fails.
     */
    public function external($data) {
        $endpoint = UrlFactory::create($this->provider, 'account-inquiry-external');
        $url = config("snapbi.{$this->provider}.url") . '/'. $endpoint;

        $headers = new HeaderFactory(
            authorization: $this->authToken->get(),
            timestamp: $this->timestamp,
            partnerId: config("snapbi.{$this->provider}.client_id"),
            externalId: config("snapbi.{$this->provider}.external_id"),
            channelId: config("snapbi.{$this->provider}.channel_id"),
            signature: ServiceSignature::generate([
                'provider' => $this->provider,
                'authToken' => $this->authToken->get(),
                'timestamp' => $this->timestamp,
                'endpoinUrl' => "/{$endpoint}",
                'httpMethod' => 'POST',
                'payload' => $data,
            ])
        );

        $req = $this->requestor
                ->withHeaders($headers->toArray())
                ->post($url, $data);

        if ( !$req->successful() ) {
            return json_decode($req->getBody());
        }

        return $req->object();
    }

    /**
     * Execute an internal account inquiry request.
     *
     * @param array $data The payload data for the request.
     *
     * @return mixed The response object from the API.
     * @throws \Exception If the request fails.
     */
    public function internal($data) {
        $endpoint = UrlFactory::create($this->provider, 'account-inquiry-internal');
        $url = config("snapbi.{$this->provider}.url") . '/'. $endpoint;

        $headers = new HeaderFactory(
            authorization: $this->authToken->get(),
            timestamp: $this->timestamp,
            partnerId: config("snapbi.{$this->provider}.client_id"),
            externalId: config("snapbi.{$this->provider}.external_id"),
            channelId: config("snapbi.{$this->provider}.channel_id"),
            signature: ServiceSignature::generate([
                'provider' => $this->provider,
                'authToken' => $this->authToken->get(),
                'timestamp' => $this->timestamp,
                'endpoinUrl' => "/{$endpoint}",
                'httpMethod' => 'POST',
                'payload' => $data,
            ])
        );

        $req = $this->requestor
                ->withHeaders($headers->toArray())
                ->post($url, $data);

        if ( !$req->successful() ) {
            return json_decode($req->getBody());
        }

        return $req->object();
    }
}
