<?php

namespace App\Tests\Client;

use App\Client\HereClient;
use App\Service\Here\DTO\RouteQueryDTO;
use App\Service\Here\DTO\RouteResponseDTO;
use App\Service\Here\DTO\RoutesResponseDTO;
use App\Service\Here\DTO\SectionResponseDTO;
use App\Service\Here\DTO\TravelSummaryResponseDTO;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class HereClientTest extends TestCase
{

    public function testSendRouteRequest()
    {
        $travelSummaryResponseDTO = new TravelSummaryResponseDTO();
        $travelSummaryResponseDTO->setDuration(123);
        $travelSummaryResponseDTO->setLength(4500);

        $section = new SectionResponseDTO();
        $section->setTravelSummary($travelSummaryResponseDTO);

        $route = new RouteResponseDTO();
        $route->setId('uuid134');
        $route->setSections([$section]);

        $mockBody = new RoutesResponseDTO();
        $mockBody->setRoutes([$route]);

        $serializer = new Serializer(
            [new ObjectNormalizer(), new GetSetMethodNormalizer()],
            [
                new JsonEncoder(
                    new JsonEncode(),
                    new JsonDecode([JsonDecode::ASSOCIATIVE => false])
                )
            ]
        );

        $mockResponse = new MockResponse(
            $serializer->serialize($mockBody, 'json'),
            [
                'response_headers' => ['content-type' => 'application/json']
            ]
        );
        $client = new MockHttpClient([$mockResponse]);

        $hereClient = new HereClient($client, $serializer, 'https://router.hereapi.com/v8', 'r');

        $req = new RouteQueryDTO();
        $req->setOrigin(sprintf('%d,%d', 44.1, 50.1));
        $req->setDestination(sprintf('%d,%d', 44.2, 50.2));

        $responseDTO = $hereClient->sendRouteRequest($req);


        $expected = $serializer->serialize($mockBody, 'json');
        $actual = $serializer->serialize($responseDTO, 'json');


        $this->assertEquals($expected, $actual);
    }

    public function testSendRouteRequest500()
    {
        $route = new RouteResponseDTO();

        $body = new RoutesResponseDTO();

        $body->setRoutes([$route]);
        $mockResponse = new MockResponse(
            json_encode($body),
            [
                'http_code' => 500,
                'response_headers' => [
                    'content-type' => 'application/json'
                ]
            ]
        );

        $client = new MockHttpClient([$mockResponse]);

        $serializer = new Serializer([new GetSetMethodNormalizer()], [new JsonEncoder()]);

        $hereClient = new HereClient($client, $serializer, 'https://router.hereapi.com/v8', 'r');

        $req = new RouteQueryDTO();
        $req->setOrigin(sprintf('%d,%d', 44.1, 50.1));
        $req->setDestination(sprintf('%d,%d', 44.2, 50.2));

        $this->expectException(\Exception::class);

        $hereClient->sendRouteRequest($req);
    }
}
