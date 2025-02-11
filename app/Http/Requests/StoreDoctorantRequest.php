<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorantRequest extends FormRequest
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
            'CIN' => 'required',
            'APOGEE' => 'required',
            'NOM' => 'required',
            'PRENOM' => 'required', 
            'date_inscription' => 'required', 
            'nationalite' => 'required', 
            'date_soutenance' => 'nullable', 
            'sujet_these' => 'required', 
            'user_id' => 'required',
        ];
    }
}
