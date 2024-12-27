<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'delete_user',

            'add_category',
            'edit_category',
            'delete_category',

            'add_product',
            'edit_product',
            'delete_product',
            'show_product',

            'manage_orders',

            'manage_settings',

            'add_admin',
            'edit_admin',
            'delete_admin',

            'add_role',
            'edit_role',
            'delete_role',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission], [
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }
    }
}
