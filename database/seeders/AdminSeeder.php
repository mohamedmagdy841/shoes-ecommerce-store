<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::create([
            'name' => 'Admin Mohamed Magdy',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'phone' => '0123456789',
            'street' => '15th street',
            'city' => 'Nasr City',
            'country' => 'Egypt'
        ]);

        $admin->assignRole('Super Admin');
    }
}
