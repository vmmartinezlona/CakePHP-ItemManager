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
      $items = $this->table('items');
      $items
        ->addColumn('name', 'string', ['limit' => 255])
        ->addColumn('vendor_id', 'integer', ['limit' => 11])
        ->addColumn('type_id', 'integer', ['limit' => 11])
        ->addColumn('serial_number', 'string', ['limit' => 10, 'unique' => true])
        ->addColumn('price', 'float')
        ->addColumn('weight', 'float')
        ->addColumn('color', 'string', ['limit' => 255])
        ->addColumn('release_date', 'datetime', ['null' => true])
        ->addColumn('photo', 'string', ['limit' => 500])
        ->addColumn('created_date', 'datetime', ['null' => true])
        ->addColumn('release_date', 'datetime', ['null' => true])
        ->addColumn('user_id', 'integer', ['limit' => 11])
        ->create();

        $items_tags = $this->table('items_tags');
        $items_tags
          ->addColumn('item_id', 'integer', ['limit' => 11])
          ->addColumn('tags_id', 'integer', ['limit' => 11])
          ->create();
        
        $tags = $this->table('tags');
        $tags
          ->addColum('name', 'string', ['limit' => 255])
          ->create();

        $types = $this->table('types');
        $types
          ->addColum('name', 'string', ['limit' => 255])
          ->create();

        $users = $this->table('users');
        $users
          ->addColumn('username', 'string', ['limit' => 255])
          ->addColumn('email', 'string', ['limit' => 255])
          ->addColumn('password', 'string', ['limit' => 255])
          ->addColumn('isActive', 'integer', ['default' => 0])
          ->addColumn('is_admin', 'integer', ['default' => 0])
          ->addColumn('created_date', 'datetime', ['null' => true])
          ->create();

        $vendors = $this->table('vendors');
        $vendors
          ->addColum('name', 'string', ['limit' => 255])
          ->addColum('logo', 'string', ['limit' => 500])
          ->addColumn('user_id', 'integer', ['limit' => 11])
          ->create();     
    }
}
