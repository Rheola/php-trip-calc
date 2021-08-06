<?php

namespace App\Service\Trip\Model;

use App\Geo\Point;

class PointModel
{
    protected float $lat;
    protected float $lon;

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat(float $lat): PointModel
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return float
     */
    public function getLon(): float
    {
        return $this->lon;
    }

    /**
     * @param float $lon
     */
    public function setLon(float $lon): PointModel
    {
        $this->lon = $lon;
        return $this;
    }

    public function toPoint(): Point
    {
        return new Point($this->lat, $this->lon);
    }
}