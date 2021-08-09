<?php

declare(strict_types=1);

namespace App\Service\Here\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class RoutesResponseDTO
{
    /**
     * @var RouteResponseDTO[]
     * @SerializedName("routes")
     */
    protected array $routes;

    /**
     * @return RouteResponseDTO[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param RouteResponseDTO[] $routes
     */
    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }

}