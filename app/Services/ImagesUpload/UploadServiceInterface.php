<?php

namespace App\Services\ImagesUpload;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;
interface UploadServiceInterface
{
    public function upload(array $data);
}
