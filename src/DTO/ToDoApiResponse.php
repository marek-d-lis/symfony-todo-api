<?php declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Serializer\Attribute\Groups;

readonly class ToDoApiResponse
{

    public function __construct(
        #[Groups(['todo:read'])]
        private string $id,

        #[Groups(['todo:read', 'todo:write'])]
        private string $title,

        #[Groups(['todo:read', 'todo:write'])]
        private ?string $description = null
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
