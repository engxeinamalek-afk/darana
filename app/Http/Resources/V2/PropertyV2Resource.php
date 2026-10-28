<?php

namespace App\Http\Resources\V2;

use App\Http\Resources\V1\PropertyV1Resource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyV2Resource extends PropertyV1Resource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        if (array_key_exists('price', $data)) {
            $data['price'] = [
                'amount'   => $this->price,
                'currency' => $this->currency
            ];
        }

        return $data;

    }
}
