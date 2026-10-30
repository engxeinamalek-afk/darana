<?php

namespace App\Services;
use Illuminate\Support\Facades\Cache;
use App\Models\Property;
use App\Models\User;
use App\Scopes\AvailableScope;

class GetPropertiesService
{
    public function show(Property $property){
        $cacheKey = "property_show_{$property->id}";

        return Cache::remember($cacheKey, now()->addMinute(10), function () use ($property) {
            return $property->load([
                    'images:id,imageable_id,imageable_type,path',
                    'city:id,name',
                    'office:id,name',
                    'owner:id,name,phone'
                ]);
        });
    }

    
    public function getFeaturedPropertires(?string $cursor = 'page_1'){
        $cursorKey = $cursor ?? 'first_page';
        $cacheKey = "properties_featured_cursor_{$cursorKey}";
        return Cache::tags(['featured_properties'])->remember($cacheKey, now()->addMinute(10), function () {
            return Property::select('id', 'city_id', 'type', 'title', 'price', 'currency', 'created_at')
                ->with('city:id,name')
                ->featured(1)
                ->latest()
                ->cursorPaginate(12);
        });
    }

    public function getOfficeProperties(User $user, int $limit){
        $page = request()->query('page', 1);
        $tagKey = "user_{$user->id}_properties";
        $cacheKey = "office_{$user->id}_properties_page_{$page}";

        return Cache::tags([$tagKey])->remember($cacheKey, now()->addMinute(20), function () use ($user, $page,$limit) {
            return $user->properties()->withoutGlobalScope(AvailableScope::class)
                        ->select('id', 'city_id', 'type', 'title', 'price', 'currency', 'created_at')
                        ->with('city:id,name')
                        ->latest()
                        ->paginate($limit);
        });

    }
}
