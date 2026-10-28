<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyV1Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = auth()->user();
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'created_at' => $this->created_at,
            'description' => $this->description,
            'type'        => $this->type,
            'is_featured' => $this->is_featured,

            // العلاقات المحملة
            'city'   => $this->whenLoaded('city', function() {
                return new CityResource($this->city);
            }),

            'office' => $this->whenLoaded('office', function() {
                return new UserResource($this->office);
            }),

            'images' => $this->whenLoaded('images', function() {
                return ImageResource::collection($this->images);
            }),


            // حقول المكتب 
            $this->mergeWhen($user->role === 'office', [
                'internal_notes' => $this->internal_notes,
                'commission_rate' => $this->commission_rate,
                'status' => $this->status,
                'owner' => $this->whenLoaded('owner', function(){
                    return new OwnerResource($this->owner);
                })
            ]),

            // السعر
            'price'    => $this->price,

        ];
    }
}
