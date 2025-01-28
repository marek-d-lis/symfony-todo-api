<?php declare(strict_types=1);

namespace App\Application\Query;

final readonly class GetTodoByIdQuery
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
