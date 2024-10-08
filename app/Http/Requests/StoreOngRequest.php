<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOngRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:ongs'],
            'country' => ['required', 'string', 'max:255'],
            'siege_social' => ['required', 'string', 'max:255'],
            'logo' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'mdt_membership' => ['required'],
        ];
    }
}
