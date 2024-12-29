<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name'=>'Super Admin', 'guard_name'=>'admin'],
            ['name'=>'Admin', 'guard_name'=>'admin'],
            ['name'=>'Category Manager', 'guard_name'=>'admin'],
            ['name'=>'Product Manager', 'guard_name'=>'admin'],
            ['name'=>'Order Manager', 'guard_name'=>'admin'],
        ]);
    }
}
