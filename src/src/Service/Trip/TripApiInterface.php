<?php

declare(strict_types=1);

namespace App\Service\Trip;

use App\Service\Trip\Model\RequestResponse;
use App\Service\Trip\Model\ResultRequestModel;
use App\Service\Trip\Model\RouteCalcResult;
use App\Service\Trip\Model\RouteRequestModel;

interface TripApiInterface
{
    /**
     * @param RouteRequestModel $request
     * @return RequestResponse
     */
    public function routeRequest(RouteRequestModel $request): RequestResponse;


    /**
     * @param ResultRequestModel $request
     * @return RouteCalcResult
     */
    public function getResult(ResultRequestModel $request): RouteCalcResult;
}