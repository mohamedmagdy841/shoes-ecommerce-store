<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::factory(50)->create();

        $sourceFolder = 'images/products';

        $products->each(function ($product) use ($sourceFolder) {
            for ($i = 0; $i < 3; $i++) {
                Image::factory()->withImageFromFolder($sourceFolder)->create([
                    'product_id' => $product->id,
                ]);
            }
        });
    }
}
