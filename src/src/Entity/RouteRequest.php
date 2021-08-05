<?php

declare(strict_types=1);

namespace App\Entity;

use App\Geo\Point;
use App\Repository\RouteRequestRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RouteRequestRepository::class)
 */
class RouteRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="point")
     * @var Point
     */
    private Point $from_point;

    /**
     * @ORM\Column(type="point")
     * @var Point
     */
    private Point $to_point;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $distance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $duration;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private ?DateTimeImmutable $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private ?DateTimeImmutable $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromPoint(): Point
    {
        return $this->from_point;
    }

    public function setFromPoint($from_point): self
    {
        $this->from_point = $from_point;

        return $this;
    }

    public function getToPoint(): Point
    {
        return $this->to_point;
    }

    public function setToPoint($to_point): self
    {
        $this->to_point = $to_point;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(?int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
