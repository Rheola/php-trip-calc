<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\Trip\TripApiInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TripController extends ApiController
{


    private TripApiInterface $api;


    /**
     * TripController constructor.
     * @param TripApiInterface    $api
     * @param SerializerInterface $serializer
     * @param ValidatorInterface  $validator
     */
    public function __construct(TripApiInterface $api, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->api = $api;
        parent::__construct($serializer, $validator);
    }


    /**
     * @Route("/trip", methods={"POST"})
     */
    public function trip(Request $request): Response
    {
        $requestModel = $this->readModel($request, 'App\Service\Trip\Model\RouteRequestModel');

        if ($requestModel instanceof Response) {
            return $requestModel;
        }

        try {
            $handler = $this->api;

            // Make the call to the business logic
            $responseCode = 200;
             $result = $handler->routeRequest($requestModel);

            return $this->getResponse($result, $responseCode, []);
        } catch (\Exception $exception) {
            return $this->createErrorResponse(
                new HttpException(
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    'An unsuspected error occurred.', $exception
                )
            );
        }
    }
}
