<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteRequest extends FormRequest
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
            'type_habitat_id' => ['required', 'integer', 'exists:type_habitats,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'tracking' => ['nullable', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],
            'type' => ['required'],
            'main_goal' => ['required', 'string', 'max:255'],
            'second_goal' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'string'],
            'longitude' => ['nullable', 'string'],
            // 'photo' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'logo' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ];
    }
}
