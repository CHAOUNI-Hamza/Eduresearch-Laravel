<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'revue' => 'required|string|max:255',
            'url' => 'required|max:255',
            'annee' => 'required|integer|min:1900|max:' . date('Y'),
            //'user_id' => 'required|exists:users,id',
        ];
    }
}

