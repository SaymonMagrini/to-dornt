<?php
namespace App\Models;

class Task
{
    public ?int $id;
    public int $category_id;
    public string $name;
    public array $tag_ids;
    public ?string $description;
    public ?string $due_to;
    public bool $done;
    public string $created_at;

    public function __construct(
        ?int $id,
        int $category_id,
        string $name,
        array $tag_ids = [],
        ?string $description = null,
        ?string $due_to = null,
        bool $done = false,
        string $created_at = ''
    ) {
        $this->id = $id;
        $this->category_id = $category_id;
        $this->name = $name;
        $this->tag_ids = $tag_ids;
        $this->description = $description;
        $this->due_to = $due_to;
        $this->done = $done;
        $this->created_at = $created_at;
    }
}
