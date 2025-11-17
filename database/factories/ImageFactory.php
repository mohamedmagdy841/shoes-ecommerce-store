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
        $sourceFolder = rtrim($sourceFolder, '/');

        if (!is_dir($sourceFolder)) {
            throw new \Exception("Folder does not exist: $sourceFolder");
        }

        // Load files from the folder
        $files = array_values(array_filter(scandir($sourceFolder), function ($file) use ($sourceFolder) {
            return is_file($sourceFolder . '/' . $file);
        }));

        if (empty($files)) {
            throw new \Exception("No files found in: $sourceFolder");
        }

        // Pick a random image
        $fileName = $files[array_rand($files)];

        // Read file content
        $fileContent = file_get_contents($sourceFolder . '/' . $fileName);

        // FINAL TARGET: images/p6.jpg
        $storagePath = 'images/' . $fileName;

        if ($this->isS3Available()) {
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
