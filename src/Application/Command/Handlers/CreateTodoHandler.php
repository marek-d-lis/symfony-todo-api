<?php declare(strict_types=1);

namespace App\Application\Command\Handlers;

use App\Application\Command\CreateTodoCommand;
use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateTodoHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(CreateTodoCommand $command): Todo
    {
        $todo = new Todo();
        $todo->setTitle($command->getTitle());
        $todo->setDescription($command->getDescription());
        $todo->setCompleted(false);

        $this->entityManager->persist($todo);
        $this->entityManager->flush();

        return $todo;
    }
}
