<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class FilePublicManager
{
    protected $disk;

    public function __construct($disk = 'uploads')
    {
        $this->disk = $disk;
    }

    public function uploadFile($file, $directory = 'general')
    {

        $extension = $file->getClientOriginalExtension();
        $timestamp = Carbon::now()->timestamp.Str::random(10);
        $filename = $timestamp . '.' . $extension;
        $path="{$this->disk}/{$directory}/{$filename}";
        $file->move(public_path("{$this->disk}/{$directory}"), $filename);
        return $path;
    }

    public function deleteFile($path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
    public function updateFile($path,$file=null, $directory = 'general')
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
            $extension = $file->getClientOriginalExtension();
            $timestamp = Carbon::now()->timestamp.Str::random(10);
            $newName = $timestamp . '.' . $extension;
            $newPath="{$this->disk}/{$directory}/{$newName}";
            $file->move(public_path("{$this->disk}/{$directory}"), $newName);
            return $newPath;

    }

}
