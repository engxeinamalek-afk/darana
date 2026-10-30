<?php

namespace App\Providers;

use App\Models\Property;
use App\Models\User;
use App\Policies\OfficePolicy;
use App\Scopes\AvailableScope;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Services\ImagesUpload\LocalUploadService;
use App\Services\ImagesUpload\UploadServiceInterface;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UploadServiceInterface::class, LocalUploadService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, OfficePolicy::class);
        Relation::morphMap([
            'property' => \App\Models\Property::class,
            'office'     => \App\Models\User::class,
        ]);
        Route::bind('office_property', function (string $value) {
            return Property::query()
                ->withoutGlobalScope(AvailableScope::class) 
                ->where('id', $value)
                ->firstOrFail();
        });

        Route::bind('imageable', function ($value) {
            $type = request()->route('imageable_type');

            $morphMap = Relation::morphMap();

            if (array_key_exists($type, $morphMap)) {
                $modelClass = $morphMap[$type]; 
                return $modelClass::findOrFail($value);
            }

            abort(404, "The resource is not defined in the morph map.");
        });
}

    }
