<?php
declare(strict_types=1);
use Phinx\Migration\AbstractMigration;

final class CreateTaskCategories extends AbstractMigration {
    public function change(): void {
        $table = $this->table('task_categories');
        $table->addColumn('task_id','integer')
              ->addColumn('category_id','integer')
              ->addForeignKey('task_id','tasks','id',['delete'=>'CASCADE'])
              ->addForeignKey('category_id','categories','id',['delete'=>'CASCADE'])
              ->addIndex(['task_id','category_id'],['unique'=>true])
              ->create();
    }
}
