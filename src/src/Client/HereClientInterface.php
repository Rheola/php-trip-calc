<?php
declare(strict_types=1);

namespace App\Client;

use App\Service\Here\DTO\RouteQueryDTO;
use App\Service\Here\DTO\RoutesResponseDTO;

interface HereClientInterface
{
    /**
     * @param RouteQueryDTO $query
     * @return RoutesResponseDTO
     */
    public function sendRouteRequest(RouteQueryDTO $query):RoutesResponseDTO;

    public function getCalcRouteResult();
}