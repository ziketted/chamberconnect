<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\Admin\ChamberManagementService;

class CertifyChamberRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isSuperAdmin();
    }

    /**
     * Obtient les règles de validation pour la requête.
     */
    public function rules(): array
    {
        return [
            'state_number' => [
                'required',
                'string',
                'max:50',
                'unique:chambers,state_number,' . ($this->chamber->id ?? 'NULL'),
            ],
            'certification_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],
            'certification_notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés.
     */
    public function messages(): array
    {
        return [
            'state_number.required' => 'Le numéro d\'état est requis.',
            'state_number.unique' => 'Ce numéro d\'état existe déjà.',
            'state_number.max' => 'Le numéro d\'état ne doit pas dépasser 50 caractères.',
            'certification_date.date' => 'La date de certification doit être une date valide.',
            'certification_date.before_or_equal' => 'La date de certification ne peut pas être dans le futur.',
            'certification_notes.max' => 'Les notes ne doivent pas dépasser 1000 caractères.',
        ];
    }
}

