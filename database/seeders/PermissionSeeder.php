<?php

namespace Database\Seeders;

use App\Traits\PermissionMakeable;
use App\Models\Role;
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
            'guard_name' => 'admin'
        ]);

        Role::firstOrCreate([
            'name' => 'owner',
            'guard_name' => 'admin'
        ]);

        $this->makePermission('role');
        $this->makePermission('user');
        $this->makePermission('admin');
    }
}
