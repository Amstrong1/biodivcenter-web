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
            'order' => ['required', 'exists:orders,id'],
            'classification' => ['required', 'exists:classifications,id'],
            'family' => ['required', 'exists:families,id'],
            'genus' => ['required', 'exists:genera,id'],
            'reign' => ['required', 'exists:reigns,id'],
            'branch' => ['required', 'exists:branches,id'],
            'status_uicn' => ['nullable', 'string', 'max:2'],
            'status_cites' => ['nullable', 'string', 'max:3'],
            'scientific_name' => ['required', 'string', 'max:255'],
            'french_name' => ['required', 'string', 'max:255'],
            'english_name' => ['nullable', 'string', 'max:255'],
            'uicn_link' => ['nullable', 'string', 'max:255'],
            'inaturalist_link' => ['nullable', 'string', 'max:255'],
        ];
    }
}
