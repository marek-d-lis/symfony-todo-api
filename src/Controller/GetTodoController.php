<?php declare(strict_types=1);

namespace App\Controller;

use App\Application\Query\GetTodoByIdQuery;
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
#[Route('/api/todos/{id}', name: 'api_todos_get_one', methods: ['GET'])]
final readonly class GetTodoController
{
    public function __construct(
        private MessageBusInterface $queryBus,
        private SerializerInterface $serializer,
        private ApiResponseTransformer $apiResponseTransformer
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(int $id): JsonResponse
    {
        $query = new GetTodoByIdQuery($id);
        $envelope = $this->queryBus->dispatch($query);

        /** @var HandledStamp|null $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);
        if (!$handledStamp) {
            throw new RuntimeException('No handler was able to handle GetTodoByIdQuery');
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
