<?php declare(strict_types=1);

namespace App\Application\Command;

final readonly class CreateTodoCommand
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
