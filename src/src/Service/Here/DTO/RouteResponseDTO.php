<?php
declare(strict_types=1);


namespace App\Service\Here\DTO;


class RouteResponseDTO
{
    protected string $id;

    /**
     * @var SectionResponseDTO[]
     */
    protected array $sections;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return SectionResponseDTO[]
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    /**
     * @param SectionResponseDTO[] $sections
     */
    public function setSections(array $sections): void
    {
        $this->sections = $sections;
    }
}