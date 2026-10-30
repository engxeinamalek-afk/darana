<?php

namespace App\Http\Controllers\V2\Office;

use App\Enums\PropertyStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Resources\V2\PropertyV2Resource;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Services\GetPropertiesService;
use App\Traits\ApiResponse;

class PropertyController extends Controller
{
    use ApiResponse;
    public function __construct(private GetPropertiesService $service){    }

    public function index(){
        $user = auth()->user();

        $properties= $this->service->getOfficeProperties($user);

        return $this->successResponse(
            data:['properties'=> PropertyV2Resource::collection($properties),
                                            'pagination' => [
                                                'current_page' => $properties->currentPage(),
                                                'next_page'    => $properties->nextPageUrl(),
                                                'prev_page'    => $properties->previousPageUrl(),
                                                'total_pages'  => $properties->lastPage(),
                                            ]],
            message:"Properties retriesved successfully"
        );
    }

    public function show(Property $property){
        Gate::authorize('access', $property);

        $property= $this->service->show($property);

        return $this->successResponse(new PropertyV2Resource($property),"Property retrieved successfully");
    }

    public function updateStatus(Property $property)
    {
        Gate::authorize('access', $property);

        if ($property->status === PropertyStatus::SOLD) {
            return $this->successResponse(
                new PropertyV2Resource($property),
                "This property already sold", 
                422
            ); 
        }
        $property->update(['status' => 'sold']);

        return $this->successResponse(new PropertyV2Resource($property),
                                        "Property updated successfully");
    }

    public function toggleFeatured(Property $property)
    {
        Gate::authorize('access', $property);
        $property->update([
            'is_featured' => !$property->is_featured
        ]);

        return $this->successResponse(new PropertyV2Resource($property),
                                     "Property updated successfully");
    }

    public function store(StorePropertyRequest $request){
        $data= $request->validated();
        $data['office_id']= auth()->user()->id;
        $property= Property::create($data);
        return $this->successResponse(new PropertyV2Resource($property),
                                        "Property stored successfully", 201);
    }





}
