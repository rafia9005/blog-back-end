<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressCreateRequest extends FormRequest
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
            'line_1' => ['required'],
            'line_2' => ['nullable'],
            'city' => ['required', 'max:100'],
            'state' => ['required', 'max:100'],
            'postal_code' => ['required', 'max:20'],
            'country' => ['required', 'max:100']
        ];
    }
}
