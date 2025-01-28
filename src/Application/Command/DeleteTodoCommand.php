<?php declare(strict_types=1);

namespace App\Application\Command;

final readonly class DeleteTodoCommand
{
    public function __construct(
        private int $id
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
