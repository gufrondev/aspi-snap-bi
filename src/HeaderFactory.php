<?php

namespace App\Libraries\AspiSnapBI;

class HeaderFactory
{
    public function __construct(
        protected $userAgent = 'DotX/Middleware',
        protected $contentType = 'application/json',
        protected $timestamp = '',
        protected $authorization = '',
        protected $clientKey = '',
        protected $signature = '',
        protected $partnerId = '',
        protected $externalId = '',
        protected $deviceId = '',
        protected $channelId = '',
        protected $privateKey = '',
        protected $clientSecret = '',
        protected $endpoinUrl = '',
        protected $accessToken = '',
        protected $httpMethod = '',
    ) {}

    public function toArray()
    {
        $header = [
            'User-Agent' => $this->userAgent,
            'Content-Type' => $this->contentType,
            'X-TIMESTAMP' => $this->timestamp,
            'Authorization' => 'Bearer ' . $this->authorization,
            'X-CLIENT-KEY' => $this->clientKey,
            'X-CLIENT-SECRET' => $this->clientSecret,
            'X-SIGNATURE' => $this->signature,
            'X-PARTNER-ID' => $this->partnerId,
            'X-EXTERNAL-ID' => $this->externalId,
            'X-DEVICE-ID' => $this->deviceId,
            'CHANNEL-ID' => $this->channelId,
            'Private_Key' => $this->privateKey,
            'EndpoinUrl' => $this->endpoinUrl,
            'AccessToken' => $this->accessToken,
            'HttpMethod' => $this->httpMethod,
        ];

        // Remove header elements that are empty
        $header = array_filter($header);

        return $header;
    }
}
