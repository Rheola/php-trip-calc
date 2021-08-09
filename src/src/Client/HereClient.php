<?php

declare(strict_types=1);

namespace App\Client;

use App\Service\Here\DTO\RouteQueryDTO;
use App\Service\Here\DTO\RoutesResponseDTO;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HereClient implements HereClientInterface
{

    protected HttpClientInterface $client;
    protected SerializerInterface $serializer;
    private string $apiUrl;
    private string $apiKey;


    /**
     * HereClient constructor.
     * @param HttpClientInterface $client
     * @param SerializerInterface $serializer
     * @param string              $hereApiUrl
     * @param string              $hereApiKey
     */
    public function __construct(
        HttpClientInterface $client,
        SerializerInterface $serializer,
        string $hereApiUrl,
        string $hereApiKey
    ) {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->apiUrl = $hereApiUrl;
        $this->apiKey = $hereApiKey;
    }


    /**
     * @param RouteQueryDTO $query
     * @return RoutesResponseDTO
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function sendRouteRequest(RouteQueryDTO $query): RoutesResponseDTO
    {
        $params = $query->toArray();
        $params['apikey'] = $this->apiKey;

        $response = $this->client->request(
            Request::METHOD_GET,
            $this->apiUrl . '/routes?' . http_build_query($params),
            [
                'timeout' => 600,
            ]
        );

        if ($response->getStatusCode() == Response::HTTP_OK) {
            /** @var RoutesResponseDTO $bodyResponseDTO */

            $bodyResponseDTO = $this->serializer->deserialize(
                $response->getContent(),
                RoutesResponseDTO::class,
                'json',
                ['disable_type_enforcement' => true]
            );

            return $bodyResponseDTO;
        }

        throw new \Exception( "Unexpected HTTP status:" . $response->getStatusCode(), 500);
    }
}