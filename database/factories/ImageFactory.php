<?php

namespace Database\Factories;

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
        $fileContent = Storage::get($file);
        $fileName = basename($file);
        $storagePath = 'images/' . $fileName;

        if ($this->isS3Available()){
            Storage::disk('s3')->put($storagePath, $fileContent);
            $url = Storage::disk('s3')->url($storagePath);
        } else {
            Storage::disk('public')->put($storagePath, $fileContent);
            $url = 'storage/' . $storagePath;
        }

        return $this->state([
            'path' => $url,
        ]);

    }

    private function isS3Available(): bool
    {
        try {
            return count(Storage::disk('s3')->files('images/')) >= 0;
        } catch (\Exception $e) {
            return false;
        }
    }
}
