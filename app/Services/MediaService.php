<?php

namespace App\Services;

class MediaService
{
    static function uploadPost($image, $extension)
    {
        $name = rand(9999, 99999) . '.' . $extension;
        $path = 'posts';
        $filePath = 'posts/' . $name;
        $response = $image->move($path, $name);
        return $filePath;
    }
}
