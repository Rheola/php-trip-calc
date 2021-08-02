<?php

namespace App\Client;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HereClient implements HereClientInterface
{

    protected HttpClientInterface $client;
    protected SerializerInterface $serializer;

    /**
     * HereClient constructor.
     * @param HttpClientInterface $client
     * @param SerializerInterface $serializer
     */
    public function __construct(HttpClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }


    public function sendRouteRequest()
    {
    }

    public function getCalcRouteResult()
    {
    }
}