<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTagsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('tags');
        $table
            ->addColumn('name', 'string', ['limit' => 32])
            ->addColumn('description', 'string', ['limit' => 256]) // <-- ADICIONADO
            ->addTimestamps()
            ->create();
    }
}
