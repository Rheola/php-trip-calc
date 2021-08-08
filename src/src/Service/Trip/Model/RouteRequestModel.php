<?php

declare(strict_types=1);

namespace App\Service\Trip\Model;

use Symfony\Component\Validator\Constraints as Assert;

use App\Service\Here\DTO\RouteQueryDTO;

class RouteRequestModel
{
    /**
     * @Assert\NotNull()
     */
    protected PointModel $from;

    /**
     * @Assert\NotNull()
     */
    protected PointModel $to;

    /**
     * @return PointModel
     */
    public function getFrom(): PointModel
    {
        return $this->from;
    }

    /**
     * @param PointModel $from
     */
    public function setFrom(PointModel $from): void
    {
        $this->from = $from;
    }

    /**
     * @return PointModel
     */
    public function getTo(): PointModel
    {
        return $this->to;
    }

    /**
     * @param PointModel $to
     */
    public function setTo(PointModel $to): void
    {
        $this->to = $to;
    }

    public function toRouteQueryDTO(): RouteQueryDTO
    {
        $from = $this->getFrom();
        $to = $this->getTo();
        $dto = new RouteQueryDTO();
        $dto
            ->setOrigin(sprintf('%d,%d', $from->getLat(), $from->getLon()))
            ->setDestination(sprintf('%d,%d', $to->getLat(), $to->getLon()));
        return $dto;
    }
}