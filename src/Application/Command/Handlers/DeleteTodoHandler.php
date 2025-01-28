<?php declare(strict_types=1);

namespace App\Application\Command\Handlers;

use App\Application\Command\DeleteTodoCommand;
use App\Application\Exception\TodoNotFoundException;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteTodoHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TodoRepository $todoRepository
    ) {
    }

    public function __invoke(DeleteTodoCommand $command): void
    {
        $todo = $this->todoRepository->find($command->getId());
        if (!$todo) {
            throw new TodoNotFoundException($command->getId());
        }

        $this->entityManager->remove($todo);
        $this->entityManager->flush();
    }
}
