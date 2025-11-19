<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTagsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('tags')
            ->addColumn('user_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('name', 'string', ['limit' => 32])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE'])
            ->create();
    }
}