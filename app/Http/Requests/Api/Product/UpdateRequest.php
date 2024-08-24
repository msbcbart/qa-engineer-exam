<?php

namespace App\Http\Requests\Api\Product;

use App\Enums\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'images' => ['array', Rule::requiredIf($this->isRequired($this->product->media, $this->deletedImages))],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'deletedImages' => ['sometimes', 'nullable', 'array']
        ];
    }

    /**
     * Determines if the images field should be required based on the current count of images 
     * saved vs count of items to be deleted
     */
    private function isRequired($media, $deletions)
    {
        $media = $media ? count($media) : 0;
        $deletions = $deletions ? count($deletions) : 0;

        return $media - $deletions < 1;
    }
}
