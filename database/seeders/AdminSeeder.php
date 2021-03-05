<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::firstOrCreate(['email' => 'app@developer.com'], [
            'name' => 'Developer',
            'password' => bcrypt('123')
        ]);

        $admin->assignRole('developer');

        $owner = Admin::firstOrCreate(['email' => 'owner@site.com'], [
            'name' => 'Owner',
            'password' => bcrypt('123')
        ]);

        $owner->assignRole('owner');
    }
}
