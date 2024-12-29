<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => null,
            'path' => null,
        ];
    }

    public function withImageFromFolder($sourceFolder)
    {
        $files = Storage::disk('local')->files($sourceFolder);
        if (empty($files)) {
            throw new \Exception("No files found in the folder: $sourceFolder");
        }

        $file = $files[array_rand($files)];

        $storagePath = 'images/' . basename($file);
        Storage::disk('public')->put($storagePath, Storage::get($file));

        return $this->state([
            'path' => 'storage/' . $storagePath,
        ]);

    }
}
