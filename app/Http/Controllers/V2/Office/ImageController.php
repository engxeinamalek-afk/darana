<?php

namespace App\Http\Controllers\V2\Office;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ImagesUpload\UploadServiceInterface;
use Illuminate\Database\Eloquent\Model;
class ImageController extends Controller
{
    public function __construct(private UploadServiceInterface $service){}
    public function store(StoreImageRequest $request, $imageable_type, Model $imageable){
        $data= $request->validated();

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
