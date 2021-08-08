<?php

declare(strict_types=1);

namespace App\Service\Trip;

use App\Client\HereClientInterface;
use App\Entity\RouteRequest;
use App\Message\RouteMessage;
use App\Repository\RouteRequestRepository;
use App\Service\Trip\Model\RequestResponse;
use App\Service\Trip\Model\ResultRequestModel;
use App\Service\Trip\Model\RouteCalcResult;
use App\Service\Trip\Model\RouteRequestModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;

class TripApi implements TripApiInterface
{

    protected HereClientInterface $hereClientInterface;
    protected EntityManagerInterface $entityManager;
    protected MessageBusInterface $bus;
    private RouteRequestRepository $routeRequestRepository;


    /**
     * TripApi constructor.
     *
     * @param HereClientInterface    $hereClientInterface
     * @param EntityManagerInterface $entityManager
     * @param MessageBusInterface    $bus
     */
    public function __construct(
        HereClientInterface $hereClientInterface,
        EntityManagerInterface $entityManager,
        MessageBusInterface $bus,
        RouteRequestRepository $routeRequestRepository
    ) {
        $this->hereClientInterface = $hereClientInterface;
        $this->entityManager = $entityManager;
        $this->bus = $bus;
        $this->routeRequestRepository = $routeRequestRepository;
    }


    /**
     * @param RouteRequestModel $request
     * @return RequestResponse
     */
    public function routeRequest(RouteRequestModel $request): RequestResponse
    {
        $routeRequest = new RouteRequest();

        $routeRequest->setFromPoint($request->getFrom()->toPoint());
        $routeRequest->setToPoint($request->getTo()->toPoint());
        $routeRequest->setStatus(RouteRequest::STATUS_NEW);

        $entityManager = $this->entityManager;

        $entityManager->persist($routeRequest);
        $entityManager->flush();

        $this->bus->dispatch(new RouteMessage($routeRequest->getId(), []));

        $response = new RequestResponse();
        $response->setId($routeRequest->getId());

        return $response;
    }


    /**
     * @param ResultRequestModel $request
     * @return RouteCalcResult
     */
    public function getResult(ResultRequestModel $request): RouteCalcResult
    {
        $routeRequestEntity = $this->routeRequestRepository->find($request->getId());

        if ($routeRequestEntity) {
            $r = new RouteCalcResult();
            $r->setDuration($routeRequestEntity->getDuration())
                ->setDistance($routeRequestEntity->getDistance());
            return $r;
        }
        throw new NotFoundHttpException();
    }
}