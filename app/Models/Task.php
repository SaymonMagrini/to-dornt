<?php

namespace App\Models;

class Task
{
    public ?int $id;
    public int $category_id;
    public string $name;
    public array $tag_ids;
    public ?string $description;
    public ?string $due_date;
    public bool $done;
    public ?string $created_at;

    public function __construct(
        ?int $id = null,
        int $category_id = 0,
        string $name = '',
        array $tag_ids = [],
        ?string $description = null,
        ?string $due_date = null,
        bool $done = false,
        ?string $created_at = null
    ) {
        $this->id = $id;
        $this->category_id = $category_id;
        $this->name = $name;
        $this->tag_ids = $tag_ids;
        $this->description = $description;
        $this->due_date = $due_date;
        $this->done = $done;
        $this->created_at = $created_at;
    }
}