<?php

namespace App\Service\Trip;

use App\Service\Trip\Model\RouteRequest;

interface TripApiInterface
{
    public function routeRequest(RouteRequest $request);

    public function getResult(string $requestId);
}