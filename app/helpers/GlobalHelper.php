<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Image;
use Str;
class GlobalHelper
{
   public static function storeSingleImage ($image, $path)
   {
        $name_picture = Str::random(6) . '.webp';
        $picture = Image::make($image)->encode('webp', 90);
        $pathImg = "$path/$name_picture";
        Storage::put("public/" . $pathImg, $picture);
       return "$pathImg";
   }
   public static function updateSingleImage ($image, $path, $oldImage)
   {
        $name_picture = Str::random(6) . '.webp';
        $picture = Image::make($image)->encode('webp', 90);
        $pathImg = "$path/$name_picture";
        Storage::put("public/" . $pathImg, $picture);
        if(Storage::exists("public/" . $oldImage)){
            Storage::delete("public/" . $oldImage);
        }
       return "$pathImg";
   }

   public static function deleteSingleImage ($image)
   {
        if(Storage::exists("public/" . $image)){
            Storage::delete("public/" . $image);
        }
   }
}
