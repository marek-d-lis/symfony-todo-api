<?php

namespace App\Application\Command;

readonly class ToggleTodoCommand
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