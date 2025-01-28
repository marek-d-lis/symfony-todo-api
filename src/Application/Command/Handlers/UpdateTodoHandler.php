<?php declare(strict_types=1);

namespace App\Application\Command\Handlers;

use App\Application\Command\UpdateTodoCommand;
use App\Application\Exception\TodoNotFoundException;
use App\Entity\Todo;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateTodoHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TodoRepository $todoRepository
    ) {
    }

    public function __invoke(UpdateTodoCommand $command): Todo
    {
        $todo = $this->todoRepository->find($command->getId());
        if (!$todo) {
            throw new TodoNotFoundException($command->getId());
        }

        $todo->setTitle($command->getTitle());
        $todo->setDescription($command->getDescription());

        $this->entityManager->flush();

        return $todo;
    }
}
