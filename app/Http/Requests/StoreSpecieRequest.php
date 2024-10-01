<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecieRequest extends FormRequest
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
            'status_uicn' => ['nullable', 'string'],
            'status_cites' => ['nullable', 'string'],
            'scientific_name' => ['required', 'string', 'max:255'],
            'french_name' => ['required', 'string', 'max:255'],
            'uicn_link' => ['nullable', 'string', 'max:255'],
            'inaturalist_link' => ['nullable', 'string', 'max:255'],
        ];
    }
}
