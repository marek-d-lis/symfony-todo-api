<?php

namespace App\Application\Query;

readonly class GetTodoByIdQuery
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
