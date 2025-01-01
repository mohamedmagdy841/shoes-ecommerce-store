<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ContactSeeder::class,
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
            ReviewSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            CouponSeeder::class,
        ]);
    }
}
