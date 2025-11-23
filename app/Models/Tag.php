<?php

namespace App\Models;

class Tag
{
    public ?int $id;
    public ?int $userId;
    public string $name;
    public string $description;

    public function __construct(?int $id, $userId, string $name, string $description)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->description = $description;
    }
}