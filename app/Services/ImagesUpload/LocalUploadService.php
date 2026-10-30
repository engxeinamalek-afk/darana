<?php

namespace App\Services\ImagesUpload;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
class LocalUploadService implements UploadServiceInterface
{
    public function upload(array $data){
        $path = $data['image']->store('photos', 'public');

        return $path;
    }

}
