<?php

declare(strict_types=1);

namespace App\Service\Trip\Model;
use Symfony\Component\Validator\Constraints as Assert;


class ResultRequestModel
{
    /**
     * @Assert\NotNull()
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


}