<?php

namespace App\Http\Requests;

use App\Enums\CurrencyTypes;
use App\Enums\PropertyStatus;
use App\Enums\PropertyTypes;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StorePropertyRequest extends FormRequest
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
            'owner_id'        => ['required', 'integer', 'exists:owners,id'],
            'city_id'         => ['required', 'integer', 'exists:cities,id'],

            'title'           => ['required', 'string', 'min:5', 'max:255'],
            'description'     => ['nullable', 'string', 'min:20'],
            'internal_notes'  => ['nullable', 'string', 'max:1000'], // ملاحظات داخلية للمكتب فقط

            'type'            => ['required', 'string', Rule::enum(PropertyTypes::class)],
            'is_featured'     => ['sometimes', 'boolean'], 

            'price'           => ['required', 'integer', 'min:0', 'max:9999999999'],
            'currency'        => ['required', 'string', Rule::enum(CurrencyTypes::class)], 
            'commission_rate' => ['nullable', 'numeric', 'between:0.1,100'],
        ];
    }
}
