<?php

namespace App\Tests\Controller;

use App\Entity\RouteRequest;
use App\Geo\Point;
use App\Tests\LoadDoctrine;
use App\Tests\RefreshDatabaseTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TripControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;
    use LoadDoctrine;

    public function testTrip200()
    {
        $client = static::createClient();
        $json = '{
    "from": {
        "lat": 45.028738,
        "lon": 38.968064
    },
    "to": {
        "lat": 45.052641,  
        "lon": 38.958389
    }
}';
        $client->request(
            'POST',
            '/trip/request',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $json
        );

        $this::assertResponseIsSuccessful();
        $this::assertResponseStatusCodeSame(200);
    }

    public function testTrip400()
    {
        $client = static::createClient();
        $json = '{
    "ffrom": {
        "lat": 45.028738,
        "lon": 38.968064
    },
    "to": {
        "lat": 45.052641,  
        "lon": 38.958389
    }
}';
        $client->request(
            'POST',
            '/trip/request',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $json
        );

        $this::assertResponseStatusCodeSame(400);
    }

    public function testTripWrongBody()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/trip/request',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this::assertResponseStatusCodeSame(500);
    }

    public function testGetResult()
    {
        $client = static::createClient();

        $rr = new RouteRequest();
        $fromPoint = new Point(44.34, 55.45);
        $rr->setFromPoint($fromPoint);
        $rr->setToPoint(new Point(5, 6));
        $rr->setStatus(RouteRequest::STATUS_FAIL);
        $rr->setDuration(60 * 20);
        $rr->setDistance(5234);

        $entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $entityManager->persist($rr);
        $entityManager->flush();

        $json = '{
    "id":  ' . $rr->getId() . ' 
}';
        $client->request(
            'POST',
            '/trip/result',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $json
        );

        $this::assertResponseIsSuccessful();
        $this::assertResponseStatusCodeSame(200);
    }

    public function testGetResult400()
    {
        $client = static::createClient();

        $json = '{}';
        $client->request(
            'POST',
            '/trip/result',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $json
        );

        $this::assertResponseStatusCodeSame(400);
    }

    public function testGetResult404()
    {
        $client = static::createClient();

        $json = '{
    "id":  100 
}';
        $client->request(
            'POST',
            '/trip/result',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $json
        );

        $this::assertResponseStatusCodeSame(404);
    }

}
