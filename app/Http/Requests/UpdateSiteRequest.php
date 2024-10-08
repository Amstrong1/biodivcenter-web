<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteRequest extends FormRequest
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
            'type_habitat_id' => ['required', 'exists:type_habitats,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'tracking' => ['nullable', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],
            'type' => ['required'],
            'main_goal' => ['required', 'string', 'max:255'],
            'second_goal' => ['nullable', 'string', 'max:255'],
            // 'photo' => ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'logo' => ['nullable', 'max:2048'],
            'latitude' => ['required', 'regex:/^(\d{1,3})°\s*(\d{1,2})\'\s*([\d\.]+)"\s*([NSEW])$/'],
            'longitude' => ['required', 'regex:/^(\d{1,3})°\s*(\d{1,2})\'\s*([\d\.]+)"\s*([NSEW])$/'],
        ];
    }
}
