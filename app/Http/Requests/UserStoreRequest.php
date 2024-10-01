<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact' => ['required', 'string', 'max:20'],
            'ong_id' => ['required_if:role,adminONG', 'integer', 'exists:ongs,id'],
            'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'organization' => ['nullable', 'string', 'max:255'],
        ];

        if (Auth::user()->role == 'adminONG') {
            $rules['site_id'] = ['exists:sites,id,ong_id,' . Auth::user()->ong_id];
        } else if (Auth::user()->role == 'admin') {
            $rules['role'] = ['required', 'string', 'in:guest,adminONG,partner,supervisor'];
            $rules['ong_id'] = ['required_if:role,adminONG', 'exists:ongs,id'];
        }

        return $rules;
    }
}
