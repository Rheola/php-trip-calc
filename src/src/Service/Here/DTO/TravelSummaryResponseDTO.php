<?php

declare(strict_types=1);

namespace App\Service\Here\DTO;

class TravelSummaryResponseDTO
{
    protected int $duration;
    protected int $length;
    protected int $baseDuration;

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
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    /**
     * @return int
     */
    public function getBaseDuration(): int
    {
        return $this->baseDuration;
    }

    /**
     * @param int $baseDuration
     */
    public function setBaseDuration(int $baseDuration): void
    {
        $this->baseDuration = $baseDuration;
    }
}