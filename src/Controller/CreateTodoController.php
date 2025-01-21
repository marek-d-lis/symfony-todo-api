<?php

namespace App\Controller;

use App\Application\Command\CreateTodoCommand;
use App\DTO\CreateToDoRequest;
use App\Entity\Todo;
use App\Transformer\ApiResponseTransformer;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[Route('/api/todos', name: 'api_todos_create', methods: ['POST'])]
readonly class CreateTodoController
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private SerializerInterface $serializer,
        private ApiResponseTransformer $apiResponseTransformer
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(
        #[MapRequestPayload] CreateToDoRequest $createToDoRequest
    ): JsonResponse {
        $command = new CreateTodoCommand(
            $createToDoRequest->getTitle(),
            $createToDoRequest->getDescription()
        );

        $envelope = $this->commandBus->dispatch($command);

        /** @var HandledStamp|null $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);
        if (!$handledStamp) {
            throw new RuntimeException('No handler was able to handle CreateTodoCommand');
        }

        /** @var Todo $todo */
        $todo = $handledStamp->getResult();


        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->apiResponseTransformer->transform($todo),
                'json',
                ['groups' => 'todo:read']
            ),
            201
        );
    }
}
