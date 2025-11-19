<?php

namespace App\Models;

class Category
{
    public ?int $id;
    public ?int $userId;
    public string $name;
    public string $text;

    public function __construct(?int $id, $userId, string $name, string $text)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->text = $text;
    }
}
