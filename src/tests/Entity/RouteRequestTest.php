<?php

namespace App\Tests\Entity;

use App\Entity\RouteRequest;
use App\Geo\Point;
use App\Tests\BootKernel;
use App\Tests\LoadDoctrine;
use App\Tests\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RouteRequestTest extends KernelTestCase
{
    use BootKernel;
    use RefreshDatabaseTrait;
    use LoadDoctrine;

    public function testSetFromPoint()
    {
        $point = new Point(55.755818, 37.617705);

        $routeRequest = new RouteRequest();
        $routeRequest->setFromPoint($point);
        $this->assertEquals($point, $routeRequest->getFromPoint());
    }

    public function testSetStatus()
    {
        $routeRequest = new RouteRequest();
        $routeRequest->setStatus(RouteRequest::STATUS_FAIL);
        $this->assertEquals(RouteRequest::STATUS_FAIL, $routeRequest->getStatus());
    }

    public function testSetToPoint()
    {
        $point = new Point(55.755818, 37.617705);
        $routeRequest = new RouteRequest();
        $routeRequest->setToPoint($point);
        $this->assertEquals($point, $routeRequest->getToPoint());
    }

    public function testSetDuration()
    {
        $routeRequest = new RouteRequest();
        $routeRequest->setDuration(350);
        $this->assertEquals(350, $routeRequest->getDuration());
    }

    public function testSetDistance()
    {
        $routeRequest = new RouteRequest();
        $routeRequest->setDistance(4201);
        $this->assertEquals(4201, $routeRequest->getDistance());
    }


    public function testDateTime()
    {
        $routeRequest = new RouteRequest();
        $fromPoint = new Point(55.755818, 37.617705);
        $routeRequest->setFromPoint($fromPoint);
        $routeRequest->setToPoint(new Point(55.751251, 37.628321));
        $routeRequest->setStatus(RouteRequest::STATUS_FAIL);

        $this->entityManager->persist($routeRequest);
        $this->entityManager->flush();

        $entity = $this->entityManager->getRepository(RouteRequest::class)
            ->find($routeRequest->getId());

        $this->assertNotEquals(null, $entity->getUpdatedAt());
        $this->assertNotEquals(null, $entity->getCreatedAt());
    }


    public function testSetCreatedAt()
    {
        $routeRequest = new RouteRequest();
        $fromPoint = new Point(55.755818, 37.617705);
        $routeRequest->setFromPoint($fromPoint);
        $routeRequest->setToPoint(new Point(55.751251, 37.628321));
        $routeRequest->setStatus(RouteRequest::STATUS_FAIL);

        $this->entityManager->persist($routeRequest);
        $this->entityManager->flush();


        sleep(2);
        $this->entityManager->persist($routeRequest);
        $this->entityManager->flush();

        $entity = $this->entityManager->getRepository(RouteRequest::class)
            ->find($routeRequest->getId());
        $this->assertNotEquals($entity->getUpdatedAt(), $entity->getCreatedAt());
    }
}
