<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Database\Factories\BlogPostFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogPost::factory(10)->create();
    }
}
