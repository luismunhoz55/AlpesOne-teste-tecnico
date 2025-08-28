<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['nullable', 'string'],
            'brand' => ['nullable', 'string'],
            'model' => ['nullable', 'string'],
            'version' => ['nullable', 'string'],
            'year_model' => ['nullable', 'integer'],
            'year_build' => ['nullable', 'integer'],
            'optionals' => ['nullable', 'array'],
            'doors' => ['nullable', 'integer'],
            'board' => ['nullable', 'string'],
            'chassi' => ['nullable', 'string'],
            'transmission' => ['nullable', 'string'],
            'km' => ['nullable', 'integer'],
            'description' => ['nullable', 'string'],
            'created' => ['nullable', 'date'],
            'updated' => ['nullable', 'date'],
            'sold' => ['nullable', 'boolean'],
            'category' => ['nullable', 'string'],
            'url_car' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'color' => ['nullable', 'string'],
            'fuel' => ['nullable', 'string'],
            'fotos' => ['nullable', 'array']
        ];
    }
}
