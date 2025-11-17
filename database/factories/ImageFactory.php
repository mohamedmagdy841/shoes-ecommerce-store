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

        // If source is under storage/app, derive relative path for Storage::disk('local')
        $storageAppReal = realpath(storage_path('app'));
        $sourceReal = realpath($sourceFolder);
        $files = [];

        if ($storageAppReal !== false && $sourceReal !== false && str_starts_with($sourceReal, $storageAppReal)) {
            $relativePath = ltrim(substr($sourceReal, strlen($storageAppReal)), '/');
            $files = Storage::disk('local')->files($relativePath);
            // Storage::files returns full filenames relative to storage/app, convert to plain names
            $files = array_values(array_map(fn($f) => basename($f), $files));
        } else {
            // fallback to direct filesystem scan (for database/seeders/images/…)
            $files = array_values(array_filter(scandir($sourceFolder), function ($file) use ($sourceFolder) {
                return is_file($sourceFolder . '/' . $file);
            }));
        }

        if (empty($files)) {
            throw new \Exception("No files found in the folder: $sourceFolder");
        }

        $fileName = $files[array_rand($files)];

        // Read file content (use Storage if we listed via Storage::disk('local'))
        if (!empty($relativePath ?? '') && isset($relativePath)) {
            $fileRelative = trim($relativePath . '/' . $fileName, '/');
            $fileContent = Storage::disk('local')->get($fileRelative);
        } else {
            $fileContent = file_get_contents($sourceFolder . '/' . $fileName);
        }

        $storagePath = 'images/' . uniqid() . '_' . $fileName;

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
