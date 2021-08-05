<?php
declare(strict_types=1);


namespace App\Service\Here\DTO;


class SectionResponseDTO
{
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