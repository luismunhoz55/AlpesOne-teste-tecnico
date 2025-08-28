<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
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
            'id' => ['nullable', 'integer'],
            'type' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'version' => ['nullable', 'string'],
            'year_model' => ['nullable', 'integer'],
            'year_build' => ['nullable', 'integer'],
            'optionals' => ['nullable', 'array'],
            'doors' => ['required', 'integer'],
            'board' => ['required', 'string'],
            'chassi' => ['nullable', 'string'],
            'transmission' => ['required', 'string'],
            'km' => ['required', 'integer'],
            'description' => ['nullable', 'string'],
            'created' => ['required', 'date'],
            'updated' => ['required', 'date'],
            'sold' => ['required', 'boolean'],
            'category' => ['required', 'string'],
            'url_car' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'color' => ['required', 'string'],
            'fuel' => ['required', 'string'],
            'fotos' => ['nullable', 'array']
        ];
    }
}
