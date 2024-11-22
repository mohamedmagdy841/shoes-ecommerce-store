<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ["Shoes for Men", "Shoes for Women", "Shoes for Kids"];

        foreach ($data as $d) {
            Category::create([
                'name' => $d,
                'status' => 1,
            ]);
        }
    }
}
