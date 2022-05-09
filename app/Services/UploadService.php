<?php


namespace App\Services;


use Illuminate\Support\Facades\Storage;

class UploadService
{
    public function upload($file, $folder) {

        if (empty($file)) {
            return '';
        }
        $filename = $file->hashname();
        $path = $folder .  '/' . $filename;
        Storage::putFileAs($folder, $file, $filename);

        return $path;
    }

    public function handleFileUpdate($newFile, $oddFile, $folder) {

        if (!empty($newFile)) {
            $path = $this->upload($newFile, $folder);
            $this->delete([$oddFile]);

            return $path;
        }

        return $oddFile;
    }

    public function delete(array $files = []) {
        Storage::delete($files);
    }
}
