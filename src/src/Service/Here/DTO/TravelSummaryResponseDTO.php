<?php

declare(strict_types=1);

namespace App\Service\Here\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class TravelSummaryResponseDTO
{
    /**
     * @var int
     * @SerializedName("duration")
     */
    protected int $duration;

    /**
     * @var int
     * @SerializedName("length")
     */
    protected int $length;

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
}