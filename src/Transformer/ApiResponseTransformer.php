<?php declare(strict_types=1);

namespace App\Transformer;

use App\DTO\ToDoApiResponse;
use App\Entity\Todo;

final class ApiResponseTransformer
{
    public function transform(Todo $todo): ToDoApiResponse
    {
        return new ToDoApiResponse(
            $todo->getId()->toString(),
            $todo->getTitle(),
            $todo->getDescription()
        );
    }
}
