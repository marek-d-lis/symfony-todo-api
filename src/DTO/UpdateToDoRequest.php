<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateToDoRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 250)]
        private string $title,
        #[Assert\Length(min: 0, max: 5000)]
        private ?string $description = null
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}