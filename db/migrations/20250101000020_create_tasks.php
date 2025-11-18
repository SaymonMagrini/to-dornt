<?php
declare(strict_types=1);
use Phinx\Migration\AbstractMigration;

final class CreateTasks extends AbstractMigration {
    public function change(): void {
        $table = $this->table('tasks');
        $table->addColumn('user_id','integer')
              ->addColumn('title','string',['limit'=>255])
              ->addColumn('description','text',['null'=>true])
              ->addColumn('done','boolean',['default'=>false])
              ->addColumn('created_at','timestamp',['default'=>'CURRENT_TIMESTAMP'])
              ->addForeignKey('user_id','users','id',['delete'=>'CASCADE'])
              ->create();
    }
}
