<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User seed.
 */
class UserSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $hasher = new DefaultPasswordHasher();
        $password = $hasher->hash('1234');

        $columns = ['username', 'email', 'password', 'isActive', 'is_admin'];
        $adminData = [
            'username' => 'test_admin', 
            'email' => 'test.admin@test.com', 
            'password' => $password, 
            'isActive' => true, 
            'is_admin' => true
        ];
        $normalData = [
            'username' => 'test_user', 
            'email' => 'test.user@test.com', 
            'password' => $password, 
            'isActive' => true, 
            'is_admin' => false
        ];
        $table = $this->table('users');
        $table->insert($adminData);
        $table->insert($normalData);
        $table->save(); 
    }
}
