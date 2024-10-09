<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRelocationRequest extends FormRequest
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
            'animal_id' => 'required|exists:animals,id',
            'ong_destination_id' => 'required|exists:ongs,id',
            'site_destination_id' => 'required|exists:sites,id',
            'date_transfert' => 'required|date',
            'comment' => 'nullable|string|max:255',
        ];
    }
}
