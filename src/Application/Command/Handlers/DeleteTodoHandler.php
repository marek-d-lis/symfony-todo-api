<?php

namespace App\Application\Command\Handlers;

use App\Application\Command\DeleteTodoCommand;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class DeleteTodoHandler
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
            throw new NotFoundHttpException('Todo not found');
        }

        $this->entityManager->remove($todo);
        $this->entityManager->flush();
    }
}