<?php

namespace App\Tests\Handler;

use App\Client\HereClientInterface;
use App\Entity\RouteRequest;
use App\Geo\Point;
use App\Handler\TripCalcHandler;
use App\Message\RouteMessage;
use App\Repository\RouteRequestRepository;
use App\Tests\BootKernel;
use App\Tests\LoadDoctrine;
use App\Tests\RefreshDatabaseTrait;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

use PHPUnit\Framework\TestCase;

class TripCalcHandlerTest extends TestCase
{

    private RouteRequestRepository $routeRequestRepository;

    /**
     * @var EntityManagerInterface|MockObject
     */
    private $entityManager;

    /**
     * @var HereClientInterface|MockObject
     */
    private HereClientInterface $hereClientInterface;


    /**
     * @var LoggerInterface|MockObject
     */
    private $logger;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var TripCalcHandler
     */
    private $handler;

    private $requestId;

    protected function setUp(): void
    {
        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

//            self::getContainer()->get(EntityManagerInterface::class);


        $this->logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->messageBus = $this->getMockBuilder(MessageBusInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

//        $this->messageBus = self::getContainer()->get(MessageBusInterface::class);

//        $this->messageBus = new MessageBus();

        $this->routeRequestRepository = $this->getMockBuilder(RouteRequestRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->hereClientInterface = $this->getMockBuilder(HereClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->handler = new TripCalcHandler(
            $this->routeRequestRepository,
            $this->entityManager,
            $this->hereClientInterface,
            $this->logger
        );
    }

    /**
     * @test
     */
    public function willDispatchAllMessagesOnANewFile()
    {
        $rr = new RouteRequest();
        $fromPoint = new Point(44.34, 55.45);
        $rr->setFromPoint($fromPoint);
        $rr->setToPoint(new Point(5, 6));
        $rr->setStatus(RouteRequest::STATUS_FAIL);
        $rr->setDuration(60 * 20);
        $rr->setDistance(5234);
        $rr->setId(14);

        $this->entityManager->persist($rr);
        $this->entityManager->flush();

        $this->requestId = $rr->getId();

        $message = new RouteMessage($this->requestId);


//        $this->messageBus->dispatch(new RouteMessage($this->requestId, []));

//        $this->messageBus->dispatch(new RouteMessage($this->requestId, []));



//        $this->assertCount(1, $this->messageBus->getDispatchedMessages());

        $this->messageBus->expects(self::exactly(1))
            ->method('dispatch')
            ->withConsecutive(
                self::isInstanceOf(RouteMessage::class),
            )
            ->willReturn(new  Envelope($message));
        ;

//        $this->messageBus->dispatch(self::exactly(1))
//            ->method('dispatch')
//            ->withConsecutive(
//                [RouteMessage::class],
//            );
//
        $handler = $this->handler;
        $handler($message);


    }

}
