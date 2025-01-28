<?php declare(strict_types=1);

namespace App\Controller;

use App\Application\Query\GetAllTodosQuery;
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
#[Route('/api/todos', name: 'api_todos_list_all', methods: ['GET'])]
final readonly class GetAllTodosController
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
    public function __invoke(): JsonResponse
    {
        $query = new GetAllTodosQuery();

        $envelope = $this->queryBus->dispatch($query);

        /** @var HandledStamp|null $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);
        if (!$handledStamp) {
            throw new RuntimeException('No handler was able to handle GetAllTodosQuery');
        }

        /** @var Todo[] $todos */
        $todos = $handledStamp->getResult();

        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                array_map(fn($todo) => $this->apiResponseTransformer->transform($todo), $todos),
                'json',
                ['groups' => 'todo:read']
            ),
            201
        );
    }
}
