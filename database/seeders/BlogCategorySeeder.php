<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Fashion', 'Lifestyle', 'Health', 'Travel'];
        foreach ($data as $category) {
                BlogCategory::create([
                'name' => $category,
                'status' => 1,
            ]);
        }
    }
}
