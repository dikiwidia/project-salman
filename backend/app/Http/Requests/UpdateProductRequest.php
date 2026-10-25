<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'code' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('products', 'code')->ignore($this->route('product'))],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0', 'max:9999999999999.99'],
            'expired_date' => ['sometimes', 'nullable', 'date'],
            'supplier_name' => ['sometimes', 'required', 'string', 'max:255'],
        ];
    }
}
