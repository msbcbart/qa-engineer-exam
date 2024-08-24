<?php

namespace App\Http\Requests\Api\Product;

use App\Enums\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:254'],
            'category' => ['required', Rule::in(array_keys(ProductCategory::getOptions()))],
            'description' => ['required', 'string', 'max:1000'],
            'date_time' => ['required', 'string', 'date'],
            'images' => ['required', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ];
    }
}
