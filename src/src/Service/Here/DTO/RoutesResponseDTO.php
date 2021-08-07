<?php

declare(strict_types=1);

namespace App\Service\Here\DTO;

class RoutesResponseDTO
{
    /**
     * @var RouteResponseDTO[]
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

    public function getId()
    {
        if (count($this->routes) == 0) {
            return 0;
        }

        $route = $this->routes[0];

        return $route->getId();
    }
}