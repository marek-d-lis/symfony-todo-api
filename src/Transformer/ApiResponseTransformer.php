<?php

namespace App\Transformer;

use App\DTO\ToDoApiResponse;
use App\Entity\Todo;

class ApiResponseTransformer
{
    public function transform(Todo $todo): ToDoApiResponse
    {
        return new ToDoApiResponse(
            $todo->getId(),
            $todo->getTitle(),
            $todo->getDescription()
        );
    }
}