<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'Super Admin', 'guard_name' => 'admin'],
            ['name' => 'Admin', 'guard_name' => 'admin'],
            ['name' => 'Category Manager', 'guard_name' => 'admin'],
            ['name' => 'Product Manager', 'guard_name' => 'admin'],
            ['name' => 'Order Manager', 'guard_name' => 'admin'],
        ]);

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
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        $superAdmin = Role::where('name', 'Super Admin')->first();
        $superAdmin->syncPermissions(Permission::where('guard_name', 'admin')->get());

        $admin = Role::where('name', 'Admin')->first();
        $admin->syncPermissions(
            Permission::where('guard_name', 'admin')
                ->whereNotIn('name', ['add_role', 'edit_role', 'delete_role', 'add_admin', 'edit_admin', 'delete_admin'])
                ->get()
        );

        $categoryManager = Role::where('name', 'Category Manager')->first();
        $categoryManager->syncPermissions(Permission::where('guard_name', 'admin')->where('name', 'like', '%_category')->get());

        $productManager = Role::where('name', 'Product Manager')->first();
        $productManager->syncPermissions(Permission::where('guard_name', 'admin')->where('name', 'like', '%_product')->get());

        $orderManager = Role::where('name', 'Order Manager')->first();
        $orderManager->syncPermissions(Permission::where('guard_name', 'admin')->where('name', 'manage_orders')->get());
    }
}
