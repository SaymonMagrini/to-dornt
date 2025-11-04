<?php
namespace App\Models;

class Task
{
    public ?int $id;
    public string $title;
    public ?string $description;
    public string $due_to;
    public bool $is_completed;
    public string $created_at;

    public function __construct(
        ?int $id,
        string $title,
        ?string $description = null,
        ?string $due_to = null,
        bool $is_completed = false,
        string $created_at = ''
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->is_completed = $is_completed;
        $this->due_to = $due_to;
        $this->created_at = $created_at;
    }
}
