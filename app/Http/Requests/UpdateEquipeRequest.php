<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipeRequest extends FormRequest
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
            'nom' => 'sometimes|string|max:255',
            //'slug' => 'sometimes|string|max:255|unique:equipes,slug,' . $this->equipe->id,
            'laboratoire_id' => 'sometimes|exists:laboratoires,id',
        ];
    }
}
