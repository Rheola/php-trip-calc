<?php

declare(strict_types=1);

namespace App\Service\Here\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class SectionResponseDTO
{
    /**
     * @var TravelSummaryResponseDTO
     * @SerializedName("travelSummary")
     */
    protected TravelSummaryResponseDTO $travelSummary;

    /**
     * @return TravelSummaryResponseDTO
     */
    public function getTravelSummary(): TravelSummaryResponseDTO
    {
        return $this->travelSummary;
    }

    /**
     * @param TravelSummaryResponseDTO $travelSummary
     */
    public function setTravelSummary(TravelSummaryResponseDTO $travelSummary): void
    {
        $this->travelSummary = $travelSummary;
    }
}