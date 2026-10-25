<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:255', 'unique:products,code'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999999.99'],
            'expired_date' => ['nullable', 'date'],
            'supplier_name' => ['required', 'string', 'max:255'],
        ];
    }
}
