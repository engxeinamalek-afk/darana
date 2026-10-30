<?php

namespace App\Http\Controllers\V1\Customer;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CityController extends Controller
{
    use ApiResponse;
    public function getCount(City $city){
        $count= Cache::remember("city:{$city->id}:count", now()->addMinute(10), function () use ($city) {
            return $city->properties()->count();
        });
        return $this->successResponse(data:['count' => $count],
                                     message:"The properties count for this city was successfully fetched");
    }
}
