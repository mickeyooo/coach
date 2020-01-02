<?php

namespace App\Model;

use ApiPlatform\Core\Annotation\ApiProperty;

class MobileValidation
{
    /**
     * @var string
     * @ApiProperty(identifier=true)
     */
    private $id;

    /**
     * @var bool
     */
    private $valid;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    public function __construct(string $id = '')
    {
        $this->id = $id;
    }
}