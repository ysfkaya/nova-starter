<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Traits\PermissionMakeable;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    use PermissionMakeable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate([
            'name' => 'developer',
            'guard_name' => 'admin',
        ]);

        Role::firstOrCreate([
            'name' => 'owner',
            'guard_name' => 'admin',
        ]);

        $this->makePermission('role');
        $this->makePermission('user');
        $this->makePermission('admin');
        $this->makePermission('page');

        $this->makeOnlyPermission('backups', ['view']);
        $this->makeOnlyPermission('settings', ['view']);
    }
}
