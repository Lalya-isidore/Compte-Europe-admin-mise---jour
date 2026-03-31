<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'nom'=>'required',
            'prenom'=>'required',
            'email'=>'required|email|unique:users',
            'phone_number'=>'required',
            'password'=>'required|min:8',
            'code_parrainage'=>'nullable|string|exists:affiliations,code_affiliation',
        ];

        // Si un code de parrainage est en session, il devient obligatoire
        if (session('referral_code')) {
            $rules['code_parrainage'] = 'required|string|exists:affiliations,code_affiliation';
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'nom.reqired'=>'Le champs nom est oblicatoire',
           
            'prenom.reqired'=>'Lechamps prenom est oblicatoire',

            'email.reqired'=>'Le champs email est oblicatoire',
            'email.email'=>'Le champs email doit comporter un email',
            'email.unique'=>' ce email a été déja utiliser',

            'phone_number.required'=>'Le numéro de téléphone est obligatoire pour activer votre compte.',

            'password.reqired'=>'Le champs password est oblicatoire',
            
            'code_parrainage.required'=>'Le code de parrainage est obligatoire pour cette inscription.',
            'code_parrainage.exists'=>'Ce code de parrainage n\'existe pas ou n\'est pas valide.',
        ];
    }
}
