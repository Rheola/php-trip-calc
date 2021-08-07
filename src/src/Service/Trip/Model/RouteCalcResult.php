<?php

declare(strict_types=1);

namespace App\Service\Trip\Model;

class RouteCalcResult
{
    protected int $distance;
    protected int $duration;

    /**
     * @return int
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     */
    public function setDistance(int $distance): RouteCalcResult
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): RouteCalcResult
    {
        $this->duration = $duration;
        return $this;
    }
}