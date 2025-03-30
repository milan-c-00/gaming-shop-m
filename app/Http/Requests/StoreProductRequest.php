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
            'name' => 'required|string|min:2|max:255',
            'category' => 'required|string|min:2|max:255',
            'price' => 'required|decimal:2|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|min:2|max:512',
            'platform' => 'nullable|string|min:2|max:255',
            'release_date' => 'nullable|date',
        ];
    }
}
