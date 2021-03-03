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
        $admin = Admin::firstOrCreate(['email' => 'satis@pentayazilim.com'], [
            'name' => 'Penta',
            'password' => bcrypt('123Penta')
        ]);

        $admin->assignRole('developer');

        $owner = Admin::firstOrCreate(['email' => 'owner@pentayazilim.com'], [
            'name' => 'Owner',
            'password' => bcrypt('123Owner')
        ]);

        $owner->assignRole('owner');
    }
}
