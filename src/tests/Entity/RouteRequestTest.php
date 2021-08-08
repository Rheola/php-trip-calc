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

        $rr = new RouteRequest();
        $rr->setFromPoint($point);
        $this->assertEquals($point, $rr->getFromPoint());
    }

    public function testSetStatus()
    {
        $rr = new RouteRequest();
        $rr->setStatus(RouteRequest::STATUS_FAIL);
        $this->assertEquals(RouteRequest::STATUS_FAIL, $rr->getStatus());
    }

    public function testSetToPoint()
    {
        $point = new Point(55.755818, 37.617705);
        $rr = new RouteRequest();
        $rr->setToPoint($point);
        $this->assertEquals($point, $rr->getToPoint());
    }

    public function testSetDuration()
    {
        $rr = new RouteRequest();
        $rr->setDuration(350);
        $this->assertEquals(350, $rr->getDuration());
    }

    public function testSetDistance()
    {
        $rr = new RouteRequest();
        $rr->setDistance(4201);
        $this->assertEquals(4201, $rr->getDistance());
    }


    public function testDateTime()
    {
        $rr = new RouteRequest();
        $fromPoint = new Point(55.755818, 37.617705);
        $rr->setFromPoint($fromPoint);
        $rr->setToPoint(new Point(55.751251, 37.628321));
        $rr->setStatus(RouteRequest::STATUS_FAIL);

        $this->entityManager->persist($rr);
        $this->entityManager->flush();

        $ar = $this->entityManager->getRepository(RouteRequest::class)
            ->find($rr->getId());

        $this->assertNotEquals(null, $ar->getUpdatedAt());
        $this->assertNotEquals(null, $ar->getCreatedAt());
    }


    public function testSetCreatedAt()
    {
        $rr = new RouteRequest();
        $fromPoint = new Point(55.755818, 37.617705);
        $rr->setFromPoint($fromPoint);
        $rr->setToPoint(new Point(55.751251, 37.628321));
        $rr->setStatus(RouteRequest::STATUS_FAIL);

        $this->entityManager->persist($rr);
        $this->entityManager->flush();


        sleep(2);
        $this->entityManager->persist($rr);
        $this->entityManager->flush();

        $ar = $this->entityManager->getRepository(RouteRequest::class)
            ->find($rr->getId());
        $this->assertNotEquals($ar->getUpdatedAt(), $ar->getCreatedAt());
    }
}
