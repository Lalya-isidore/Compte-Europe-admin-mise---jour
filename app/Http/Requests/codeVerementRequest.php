<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodeVerementRequest extends FormRequest
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
            'codeVirement' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Vérifier si le code de virement est incorrect
                    if ($value != $this->getConnectedCompte()->code_virement) {
                        $fail('Le code de virement est incorrect');
                    }
                },
            ],
        ];
    }
    
    public function messages()
    {
        return [
            'codeVirement.required' => 'Le champ code est requis',
            'codeVirement.custom' => 'Le code de virement est incorrect',
        ];
    }
    
}
