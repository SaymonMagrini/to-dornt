<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTasksTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('tasks')
            ->addColumn('user_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('category_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('name', 'string', ['limit' => 64])
            ->addColumn('description', 'string', ['limit' => 256])
            ->addColumn('due_date', 'date', ['null' => true])
            ->addColumn('done', 'boolean', ['default' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE'])
            ->addForeignKey('category_id', 'categories', 'id', ['delete' => 'SET NULL'])

            ->create();
    }
}
