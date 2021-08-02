<?php

namespace App\Service\Trip\Model;

class RouteRequest
{
    protected Point $from;

    protected Point $to;

    /**
     * @return Point
     */
    public function getFrom(): Point
    {
        return $this->from;
    }

    /**
     * @param Point $from
     */
    public function setFrom(Point $from): void
    {
        $this->from = $from;
    }

    /**
     * @return Point
     */
    public function getTo(): Point
    {
        return $this->to;
    }

    /**
     * @param Point $to
     */
    public function setTo(Point $to): void
    {
        $this->to = $to;
    }
}