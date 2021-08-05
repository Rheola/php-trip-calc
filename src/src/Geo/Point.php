<?php

declare(strict_types=1);


namespace App\Geo;


class Point
{

    protected float $latitude;
    protected float $longitude;

    /**
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct($latitude = 0, $longitude = 0)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}