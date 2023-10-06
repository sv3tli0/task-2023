<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user('sanctum')?->currentAccessToken()->can('write');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:200'],
            'description' => ['required', 'string', 'min:5', 'max:20000'],
            // allow 0.00 to 9999999.99 with 2 decimal places
            'price' => ['required', 'numeric', 'between:0,9999999.99'],
        ];
    }
}
