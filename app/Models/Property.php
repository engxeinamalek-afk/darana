<?php

namespace App\Models;

use App\Enums\CurrencyTypes;
use App\Enums\PropertyStatus;
use App\Enums\PropertyTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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


}
