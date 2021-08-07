<?php

namespace App\Handler;

use App\Client\HereClientInterface;
use App\Entity\RouteRequest;
use App\Message\RouteMessage;
use App\Repository\RouteRequestRepository;
use App\Service\Here\DTO\RouteQueryDTO;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TripCalcHandler implements MessageHandlerInterface
{
    private RouteRequestRepository $routeRequestRepository;
    private EntityManagerInterface $entityManager;
    private HereClientInterface $hereClientInterface;
    private LoggerInterface $logger;


    /**
     * TripCalcHandler constructor.
     * @param RouteRequestRepository $routeRequestRepository
     * @param EntityManagerInterface $entityManager
     * @param HereClientInterface    $hereClientInterface
     * @param LoggerInterface        $logger
     */
    public function __construct(
        RouteRequestRepository $routeRequestRepository,
        EntityManagerInterface $entityManager,
        HereClientInterface $hereClientInterface,
        LoggerInterface $logger
    ) {
        $this->routeRequestRepository = $routeRequestRepository;
        $this->entityManager = $entityManager;
        $this->hereClientInterface = $hereClientInterface;
        $this->logger = $logger;
    }


    /**
     * @param RouteMessage $message
     */
    public function __invoke(RouteMessage $message)
    {
        $routeRequestEntity = $this->routeRequestRepository->find($message->getId());
        if (!$routeRequestEntity) {
            return;
        }

        $routeRequestEntity->setStatus(RouteRequest::STATUS_PROCESS);

        $this->entityManager->refresh($routeRequestEntity);
        $this->entityManager->flush();

        $from = $routeRequestEntity->getFromPoint();
        $to = $routeRequestEntity->getToPoint();

        $routeQueryDTO = new RouteQueryDTO();
        $routeQueryDTO
            ->setOrigin(sprintf('%f,%f', $from->getLatitude(), $from->getLongitude()))
            ->setDestination(sprintf('%f,%f', $to->getLatitude(), $to->getLongitude()));

        $responseDTO = $this->hereClientInterface->sendRouteRequest($routeQueryDTO);

        if (count($responseDTO->getRoutes()) == 0) {
            $this->logger->error(
                'Routes not found',
                ['route' => $message->getId()]
            );


            $routeRequestEntity->setStatus(RouteRequest::STATUS_FAIL);

            $this->entityManager->refresh($routeRequestEntity);
            $this->entityManager->flush();

            return;
        }
        $route = $responseDTO->getRoutes()[0];

        if (count($route->getSections()) == 0) {
            $this->logger->error(
                'Sections not found',
                ['route' => $message->getId()]
            );

            $routeRequestEntity->setStatus(RouteRequest::STATUS_FAIL);

            $this->entityManager->refresh($routeRequestEntity);
            $this->entityManager->flush();

            return;
        }
        $section = $route->getSections()[0];
        $routeRequestEntity->setStatus(RouteRequest::STATUS_DONE);


        $routeRequestEntity->setDistance($section->getTravelSummary()->getLength());
        $routeRequestEntity->setDuration($section->getTravelSummary()->getDuration());

        $this->entityManager->persist($routeRequestEntity);
        $this->entityManager->flush();
    }
}