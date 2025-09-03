<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    public function success($data = null,$code = 200){
        return Response::json([
            'data' => $data
        ],$code);
    }

    public function fail($error = "error",$code = 400){
        return Response::json([
            'data' => null,
            'error' => $error,
        ],$code);
    }

    protected function saveFile($file){
        
        $name = sha1(microtime()) .'.'. $file->getClientOriginalExtension();
        Storage::disk('public')->put('images/' . $name, file_get_contents($file));
        return 'public/images/' . $name;
    }

    protected function deleteFile($filePath)
{
    if (Storage::exists($filePath)) {
        Storage::delete($filePath);
        return true;
    }
    return false;
}
}
