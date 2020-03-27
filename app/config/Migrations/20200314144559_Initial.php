<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $items_tags = $this->table('items_tags');
        $items_tags
          ->addColumn('item_id', 'integer', ['limit' => 11])
          ->addColumn('tag_id', 'integer', ['limit' => 11])
          ->create();
        
        $tags = $this->table('tags',  ['id' => 'tag_id']);
        $tags
          ->addColumn('name', 'string', ['limit' => 255])
          ->create();

        $types = $this->table('types', ['id' => 'type_id']);
        $types
          ->addColumn('name', 'string', ['limit' => 255])
          ->create();

        $items = $this->table('items');
        $items
          ->addColumn('name', 'string', ['limit' => 255])
          ->addColumn('vendor_id', 'integer', ['limit' => 11])
          ->addColumn('type_id', 'integer', ['limit' => 11])
          ->addColumn('serial_number', 'string', ['limit' => 10])
          ->addColumn('price', 'float')
          ->addColumn('weight', 'float')
          ->addColumn('color', 'string', ['limit' => 255])
          ->addColumn('release_date', 'datetime', ['null' => true])
          ->addColumn('photo', 'string', ['limit' => 500])
          ->addColumn('created_date', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
          ->addColumn('user_id', 'integer', ['limit' => 11])
          ->addIndex(['serial_number'], ['unique' => true])
          ->addForeignKey('type_id', 'types', 'type_id', ['delete' => 'CASCADE', 'update'=> 'NO_ACTION'])
          // ->addForeignKey('type_id', 'types', 'type_id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))
          ->create();

        $users = $this->table('users');
        $users
          ->addColumn('username', 'string', ['limit' => 255])
          ->addColumn('email', 'string', ['limit' => 255])
          ->addColumn('password', 'string', ['limit' => 255])
          ->addColumn('isActive', 'integer', ['default' => 0])
          ->addColumn('is_admin', 'integer', ['default' => 0])
          ->addColumn('created_date', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
          ->create();

        $vendors = $this->table('vendors');
        $vendors
          ->addColumn('name', 'string', ['limit' => 255])
          ->addColumn('logo', 'string', ['limit' => 500])
          ->addColumn('user_id', 'integer', ['limit' => 11])
          ->create();     
    }

    /**
    * Migrate Up.
    */
    public function up()
    {
          
    }

    /**
    * Migrate Down.
    */
    public function down()
    {
        $this->execute('Delete from status where id = ' . $this->statusId);
    }
}
