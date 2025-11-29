<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class compteRequest extends FormRequest
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
        $userId = optional($this->user())->id ?? 0;

        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('comptes')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                }),
            ],
            'phone_number' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'alert_sms' => 'nullable|boolean',
            'devise' => 'required|string|max:255',
            'lang' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'account_balance' => 'required|numeric',
            'account_type' => 'required|string|max:255',
            'account_status' => 'required|string|max:255',
            'transfer_supported' => 'required|string|max:255',
            'iban' => 'nullable|string|max:34',
            'parameters' => 'nullable|json',
            'start_percentage' => 'required|integer|min:1|max:100',
            'end_percentage' => 'required|integer|min:1|max:100',
            'failure_message' => 'required|string',
            // Optional profile photo when creating/updating a compte
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    public function messages()
    {
        return[
            'nom.required' =>'Le champs nom est requis',
            'prenom.required' =>'Le champs prenom est requis',
            'email.required' =>'Le champs email est requis',
            'email.unique' =>"Cette adresse e-mail a déjà été utilisée pour créer un Flash compte. Merci d'en choisir une autre.",
            'phone_number.required' => 'Le champs téléphone est requis',
            'country.required' =>'Le champs pays est requis',
            'devise.required' =>'Le champs devise est requis',
            'lang.required' =>'Le champs langue est requis',
            'address.required' =>'Le champs adresse est requis',
            'account_balance.required' =>'Le champs solde à créditer est requis',
            'account_type.required' =>'Le champs type est requis',
            'account_status.required' =>'Le champs statut est requis',
            'transfer_supported.required' =>'Le champs transferts supportés est requis',
            'start_percentage.required' => 'Le champs % début est requis',
            'start_percentage.min' => 'Le champs % début doit être supérieur ou égal à 1',
            'end_percentage.required' => 'Le champs % fin est requis',
            'end_percentage.min' => 'Le champs % fin doit être supérieur ou égal à 1',
            'failure_message.required' => 'Le message à afficher est requis',

        ];

    }
}
