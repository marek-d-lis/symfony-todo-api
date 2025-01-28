<?php declare(strict_types=1);

namespace App\Controller;

use App\Application\Command\ToggleTodoCommand;
use App\Entity\Todo;
use App\Transformer\ApiResponseTransformer;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[Route('/api/todos/{id}/toggle', name: 'api_todos_toggle', methods: ['PATCH'])]
final readonly class ToggleTodoController
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
    public function __invoke(int $id): JsonResponse
    {
        $command = new ToggleTodoCommand($id);

        $envelope = $this->commandBus->dispatch($command);

        /** @var HandledStamp|null $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);
        if (!$handledStamp) {
            throw new RuntimeException('No handler was able to handle ToggleTodoCommand');
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
