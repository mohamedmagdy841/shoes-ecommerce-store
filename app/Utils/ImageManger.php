<?php
namespace App\Utils;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ImageManger{

    public static function uploadImages($request , $product=null , $user=null)
    {
        if($request->hasFile('images')){
            foreach($request->images as $image){
                $file = self::generateImageName($image);
                $path = self::storeImageInLocal($image , 'products' , $file);

                $product->images()->create([
                    'path'=>$path,
                ]);
            }
        }

        // upload single image
        if($request->hasFile('image')){
            $image = $request->file('image');

            self::deleteImageFromLocal($user->image);

            $file = self::generateImageName($image);
            $path = self::storeImageInLocal($image , 'users' , $file);

            $user->update(['image'=>$path]);
        }
    }

    public static function deleteImages($product)
    {
        if ($product->images->count() > 0) {
            foreach ($product->images as $image) {
               self::deleteImageFromLocal($image->path);
               $image->delete();
            }
        }
    }

    public static function generateImageName($image)
    {
        $file = Str::uuid() . time() . '.' . $image->getClientOriginalExtension();
        return $file;
    }
    public static function storeImageInLocal($image , $path , $file_name)
    {
        $path = $image->storeAs('uploads/'.$path , $file_name , 'public');
        return $path;
    }
    public static function deleteImageFromLocal($image_path)
    {
        if (File::exists(storage_path('app/public/'.$image_path))) {
            File::delete(storage_path('app/public/'.$image_path));
        }
    }

}
