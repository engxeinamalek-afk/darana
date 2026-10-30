<?php

namespace App\Observers;

use App\Models\Property;
use Illuminate\Support\Facades\Cache;

class PropertyObserver
{
    /**
     * Handle the Property "created" event.
     */
    public function created(Property $property): void
    {
        Cache::forget("city:{$property->city_id}:count");

        Cache::tags(["user_{$property->office_id}_properties"])->flush();
    }

    /**
     * Handle the Property "updated" event.
     */
    public function updated(Property $property): void
    {
        Cache::forget("property_show_{$property->id}");


        if ($property->isDirty('is_featured')) {
            Cache::tags(['featured_properties'])->flush();            
        }

        if ($property->isDirty('status') && $property->status === 'sold') {
            Cache::forget("city:{$property->city_id}:count");

            Cache::tags(["user_{$property->office_id}_properties"])->flush();

            if ($property->is_featured) {
                Cache::tags(['featured_properties'])->flush();
            }
        }
    }

    /**
     * Handle the Property "deleted" event.
     */
    public function deleted(Property $property): void
    {
        //
    }

    /**
     * Handle the Property "restored" event.
     */
    public function restored(Property $property): void
    {
        //
    }

    /**
     * Handle the Property "force deleted" event.
     */
    public function forceDeleted(Property $property): void
    {
        //
    }
}
