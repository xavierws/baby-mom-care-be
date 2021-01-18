<?php


namespace App\Actions;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreImage
{
    public static function handle($id, $imageBase64, $path, $name, $ImageableType)
    {
        $image = base64_decode($imageBase64);
        $str = Str::random(10);
        $filename = $path . (string) $id . $name . '$' . $str . '.jpg';
        Storage::put($filename, $image);

        Image::create([
            'filename' => $filename,
            'imageable_id' => $id,
            'imageable_type' => $ImageableType,
        ]);
    }
}
