<?php

namespace App\Application\Exception;

class TodoNotFoundException extends \RuntimeException
{
    public function __construct(int $id)
    {
        parent::__construct("Todo with ID {$id} not found.");
    }
}
