<?php

namespace App\Http\Controllers\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterPropertyRequest;
use App\Http\Resources\V1\PropertyV1Resource;
use App\Models\Property;
use App\Services\GetPropertiesService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    use ApiResponse;
    public function __construct(private GetPropertiesService $service){    }

    public function index(FilterPropertyRequest $request){

        $properties = Property::select('id','city_id','type','title','price','currency','is_featured')
            ->featured($request->is_featured)
            ->inCity($request->city)
            ->ofType($request->type)
            ->priceGreaterThan($request->min_price)
            ->priceLessThan($request->max_price)
            ->with('city:id,name')->orderBy('id','asc')
            ->cursorPaginate(12)->withQueryString();

        return $this->successResponse(
                data: [
                    'properties' => PropertyV1Resource::collection($properties),
                    'pagination' =>['next_page' => $properties->nextPageUrl(),
                                    'pre_page' => $properties->previousPageUrl(),
                                    'has_more' => $properties->hasMorePages()]
                ],
                message: "Properties retrieved successfully"
        );
    }

    public function show(Property $property){

        $property= $this->service->show($property);

        return $this->successResponse(new PropertyV1Resource($property),
                                        "Property retrieved successfully");
    }

    public function getFeaturedProperties(Request $request){
        $cursor = $request->query('cursor');

        $properties= $this->service->getFeaturedPropertires($cursor);

        return $this->successResponse(data: [
                                            'properties' => PropertyV1Resource::collection($properties),
                                            'pagination' =>['next_page' => $properties->nextPageUrl(),
                                                            'pre_page' => $properties->previousPageUrl(),
                                                            'has_more' => $properties->hasMorePages()]
                                      ],
                                    message:"Featured properties retrieved successfully");
    }
}
