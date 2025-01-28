<?php

namespace App\Application\Query\Handlers;

use App\Application\Exception\TodoNotFoundException;
use App\Application\Query\GetTodoByIdQuery;
use App\Entity\Todo;
use App\Repository\TodoRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetTodoByIdHandler
{
    public function __construct(
        private TodoRepository $todoRepository
    ) {
    }

    public function __invoke(GetTodoByIdQuery $query): Todo
    {
        $todo = $this->todoRepository->find($query->getId());
        if (!$todo) {
            throw new TodoNotFoundException($query->getId());
        }

        return $todo;
    }
}
