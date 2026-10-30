<?php

namespace App\Http\Requests;

use App\Enums\PropertyTypes;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class FilterPropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'is_featured' => ['nullable', 'in:true,false,1,0'],
            'city'        => ['nullable', 'integer', 'exists:cities,id'],
            'type'        => ['nullable', new Enum(PropertyTypes::class)],
            'min_price'   => ['nullable', 'numeric', 'min:1000'],
            'max_price'   => ['nullable', 'numeric', 'min:1000', 'gte:min_price'],
        ];
    }
}
