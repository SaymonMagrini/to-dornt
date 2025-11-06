<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTasksTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('tasks')

            //regular columns
            ->addColumn('name', 'string', ['limit' => 64])
            ->addColumn('description', 'string', ['limit' => 256])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('due_date', 'date', ['null' => true])
            ->addColumn('done', 'boolean', [
                'default' => false,
                'null' => false
            ])

            //foreign key columns
            ->addColumn('category_id', 'integer', ['null' => true])
            ->addColumn('tag_id', 'integer', ['null' => true])

            //indexing key columns
            ->addIndex(['category_id'])
            ->addIndex(['tag_id'])

            ->create();

        //adding foreign keys after table creation
        $this->table('tasks')
            ->addForeignKey('category_id', 'categories', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE'
            ])
            ->addForeignKey('tag_id', 'tags', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE'
            ])
            ->update();
    }
}
