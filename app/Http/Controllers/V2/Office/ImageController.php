<?php

namespace App\Http\Controllers\V2\Office;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Http\Resources\V1\ImageResource;
use App\Services\StoreImageService;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Model;
class ImageController extends Controller
{
    use ApiResponse;
    public function __construct(private StoreImageService $service){}
    public function store(StoreImageRequest $request, $imageable_type, Model $imageable){
        $data= $request->validated();

        $image= $this->service->store($data,$imageable);

        return $this->successResponse(new ImageResource($image),"Image stored successfully");
        
    }
}
