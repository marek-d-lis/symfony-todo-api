<?php

namespace App\Application\Command;

readonly class CreateTodoCommand
{
    public function __construct(
        private string $title,
        private ?string $description
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