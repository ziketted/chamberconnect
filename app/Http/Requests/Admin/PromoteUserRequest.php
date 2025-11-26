<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class PromoteUserRequest extends FormRequest
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
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if ($user && $user->is_admin !== User::ROLE_USER) {
                        $fail('Cet utilisateur ne peut pas être promu (rôle invalide).');
                    }
                },
            ],
            'chamber_id' => [
                'nullable',
                'exists:chambers,id',
            ],
        ];
    }

    /**
     * Messages d'erreur personnalisés.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'L\'utilisateur est requis.',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas.',
            'chamber_id.exists' => 'La chambre sélectionnée n\'existe pas.',
        ];
    }
}

