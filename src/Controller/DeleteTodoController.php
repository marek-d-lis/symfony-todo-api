<?php

namespace App\Controller;

use App\Application\Command\DeleteTodoCommand;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/api/todos/{id}', name: 'api_todos_delete', methods: ['DELETE'])]
readonly class DeleteTodoController
{
    public function __construct(
        private MessageBusInterface $commandBus
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(int $id): JsonResponse
    {
        $command = new DeleteTodoCommand($id);
        $envelope = $this->commandBus->dispatch($command);

        /** @var HandledStamp|null $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);
        if (!$handledStamp) {
            throw new RuntimeException('No handler was able to handle DeleteTodoCommand');
        }


        return new JsonResponse(null, 204);
    }
}