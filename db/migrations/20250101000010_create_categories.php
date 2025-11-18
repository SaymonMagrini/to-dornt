<?php
declare(strict_types=1);
use Phinx\Migration\AbstractMigration;

final class CreateCategories extends AbstractMigration {
    public function change(): void {
        $this->table('categories')
             ->addColumn('name','string',['limit'=>120])
             ->create();
    }
}
