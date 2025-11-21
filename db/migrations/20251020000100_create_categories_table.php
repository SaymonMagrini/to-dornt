<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCategoriesTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('categories')
            ->addColumn('name', 'string', ['limit' => 32])
            ->addColumn('description', 'string', ['limit' => 256])
            ->create();
    }
}