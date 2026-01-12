<?php

namespace App;

use Illuminate\Support\ServiceProvider;
use App\Models\UserUploadPath;

class UserStorage{
    public static function put($directory, $file, $user_id){

        // Put File
        $put = putStorage($directory, $file);

        $upload = [
            'user' => $user_id,
            'path' => "$directory/$put"
        ];

        UserUploadPath::create($upload);

        return $put;
    }

    public static function putAs($directory, $file, $name, $user_id){

        // Put File
        $put = getStoragePutAs($directory, $file, $name);

        $upload = [
            'user' => $user_id,
            'path' => "$directory/$name"
        ];

        UserUploadPath::create($upload);

        return $put;
    }

    public static function remove($directory, $file){
        $location = "$directory/$file";

        UserUploadPath::where('path', $location)->delete();

        return storageDelete($directory, $file);
    }
}
