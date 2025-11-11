<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTaskTagsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('task_tags')
            ->addColumn('task_id', 'integer', ['signed' => false])
            ->addColumn('tag_id', 'integer', ['signed' => false])

            ->addIndex(['task_id', 'tag_id'], ['unique' => true])

            ->addForeignKey('task_id', 'tasks', 'id', ['delete' => 'CASCADE'])
            ->addForeignKey('tag_id', 'tags', 'id', ['delete' => 'CASCADE'])

            ->create();
    }
}
