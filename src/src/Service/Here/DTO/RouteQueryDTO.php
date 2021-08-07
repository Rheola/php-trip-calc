<?php

declare(strict_types=1);

namespace App\Service\Here\DTO;

class RouteQueryDTO
{
    protected $origin;
    protected $destination;
    protected $transportMode = 'car';

    /**
     * @return string
     */
    public function getTransportMode(): string
    {
        return $this->transportMode;
    }

    /**
     * @param string $transportMode
     */
    public function setTransportMode(string $transportMode): void
    {
        $this->transportMode = $transportMode;
    }
    protected $return = 'travelSummary';

    /**
     * @return mixed
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param $origin
     * @return $this
     */
    public function setOrigin($origin): RouteQueryDTO
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param mixed $destination
     */
    public function setDestination($destination): RouteQueryDTO
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturn(): string
    {
        return $this->return;
    }

    /**
     * @param string $return
     */
    public function setReturn(string $return): void
    {
        $this->return = $return;
    }

    public function toArray()
    {
        return [
            'origin' => $this->getOrigin(),
            'destination' => $this->getDestination(),
            'transportMode' => $this->getTransportMode(),
            'return' => $this->getReturn(),
        ];
    }
}