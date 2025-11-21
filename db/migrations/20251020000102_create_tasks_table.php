<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTasksTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('tasks')
            ->addColumn('category_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('name', 'string', ['limit' => 128])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('due_date', 'date', ['null' => true])
            ->addColumn('done', 'boolean', ['default' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])

            ->addForeignKey('category_id', 'categories', 'id', ['delete' => 'SET NULL'])

            ->create();
    }
}