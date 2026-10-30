<?php

namespace App\Services;

use App\Models\User;
use App\Services\ImagesUpload\UploadServiceInterface;
use Illuminate\Database\Eloquent\Model;

class StoreImageService{
    public function __construct(private UploadServiceInterface $service){}

    public function store(array $data, Model $imageable){

        $path= $this->service->upload($data);

        if($imageable instanceof User){
            $image= $imageable->logo()->updateOrCreate(
                [
                    'imageable_id'   => $imageable->id
                ],
                ['path' => $path]
            );
        }else{
            $image= $imageable->images()->create([
                'path' => $path
            ]);
        }
        return $image;
    }
}