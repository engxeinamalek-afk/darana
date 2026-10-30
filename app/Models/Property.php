<?php

namespace App\Models;

use App\Enums\CurrencyTypes;
use App\Enums\PropertyStatus;
use App\Enums\PropertyTypes;
use App\Scopes\AvailableScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Observers\PropertyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([PropertyObserver::class])]
class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'office_id',
        'owner_id',
        'city_id',
        'status',
        'type',
        'title',
        'description',
        'is_featured',
        'price',
        'currency',
        'internal_notes',
        'commission_rate',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new AvailableScope);
    }

    protected function casts(): array
    {
        return [
            'status' => PropertyStatus::class,
            'type' => PropertyTypes::class,
            'currency' => CurrencyTypes::class,

            'is_featured' => 'boolean',
            'price' => 'integer',
            'commission_rate' => 'float', 
        ];
    }
    public function images():MorphMany{
        return $this->morphMany(Image::class,'imageable');
    }
    public function city():BelongsTo{
        return $this->belongsTo(City::class);
    }
    public function office():BelongsTo{
        return $this->belongsTo(User::class,'office_id');
    }
    public function owner():BelongsTo{
        return $this->belongsTo(Owner::class);
    }




    public function scopeFeatured(Builder $query, $isFeatured = null): Builder
    {
        return $query->when(!is_null($isFeatured), function ($q) use ($isFeatured) {
            return $q->where('is_featured', filter_var($isFeatured, FILTER_VALIDATE_BOOLEAN));
        });
    }

    public function scopeOfType(Builder $query, ?string $type = null): Builder
    {
        $enumType = PropertyTypes::tryFrom($type);

        return $query->when($enumType, function ($q) use ($enumType) {
            return $q->where('type', $enumType);
        });
    }
    public function scopePriceGreaterThan(Builder $query, ?float $price): Builder
    {
        return $query->when($price, function ($q) use ($price) {
            return $q->where('price', '>=', $price);
        });
    }

    public function scopePriceLessThan(Builder $query, ?float $price): Builder
    {
        return $query->when($price, function ($q) use ($price) {
            return $q->where('price', '<=', $price);
        });
    }

    public function scopeInCity(Builder $query, ?string $cityId = null): Builder
    {
        return $query->when($cityId, function ($q) use ($cityId) {
            return $q->where('city_id', $cityId);
        });
    }

}
