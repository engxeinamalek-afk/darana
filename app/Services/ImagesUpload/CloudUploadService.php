<?php

namespace App\Services\ImagesUpload;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
class CloudUploadService implements UploadServiceInterface
{
    public function upload(array $data)
    {
        $path = $data['image']->store('fake-cloud-chunks', 'public');

        $fileName = basename($path);
        $fakeCloudUrl = "https://amazonaws.com" . $fileName;

        return $fakeCloudUrl;
    }
}
