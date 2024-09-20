<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLivreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'titre' => 'required|string|max:255',
            'isbn' => 'required|string|max:255',
            'depot_legal' => 'required|string|max:255',
            'issn' => 'nullable|string|max:255',
            'annee' => 'required|integer',
        ];
    }
}
