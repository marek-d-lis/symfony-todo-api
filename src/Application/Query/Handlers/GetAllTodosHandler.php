<?php declare(strict_types=1);

namespace App\Application\Query\Handlers;

use App\Application\Query\GetAllTodosQuery;
use App\Entity\Todo;
use App\Repository\TodoRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetAllTodosHandler
{
    public function __construct(
        private TodoRepository $todoRepository
    ) {
    }

    /**
     * @param GetAllTodosQuery $query
     * @return Todo[]
     */
    public function __invoke(GetAllTodosQuery $query): array
    {
        return $this->todoRepository->findAll();
    }
}
