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
        $adminArray = [
            'Admin Mohamed Magdy' => ['magdy@gmail.com', 'Super Admin'],
            'Admin' => ['admin@gmail.com', 'Admin'],
            'Category Manager Admin' => ['category@gmail.com', 'Category Manager'],
            'Product Manager Admin' => ['product@gmail.com', 'Product Manager'],
            'Order Manager Admin' => ['order@gmail.com', 'Order Manager'],
        ];

        $streets = ['10th Street', '11th Street', '12th Street', '13th Street', '14th Street'];
        $cities = ['Nasr City', 'California', 'Toronto', 'Berlin', 'Paris'];
        $countries = ['Egypt', 'USA', 'Canada', 'Germany', 'France'];

        foreach ($adminArray as $key => $value) {

            $admin = Admin::create([
                'name' => $key,
                'email' => $value[0],
                'password' => Hash::make('123456789'),
                'phone' => '01' . random_int(100000000, 999999999),
                'street' => $streets[array_rand($streets)],
                'city' => $cities[array_rand($cities)],
                'country' => $countries[array_rand($countries)],
            ]);

            $admin->assignRole($value[1]);
        }

    }
}
