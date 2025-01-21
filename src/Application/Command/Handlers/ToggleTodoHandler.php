<?php

namespace App\Application\Command\Handlers;

use App\Application\Command\ToggleTodoCommand;
use App\Entity\Todo;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ToggleTodoHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TodoRepository $todoRepository
    ) {
    }

    public function __invoke(ToggleTodoCommand $command): Todo
    {
        $todo = $this->todoRepository->find($command->getId());
        if (!$todo) {
            throw new NotFoundHttpException('Todo not found');
        }

        $todo->setCompleted(!$todo->isCompleted());
        $this->entityManager->flush();

        return $todo;
    }
}