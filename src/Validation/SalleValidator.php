<?php

namespace App\Validation;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class SalleValidator implements SalleValidatorInterface
{
    private array $messages = [
        'nom'           => "Le nom de la salle doit contenir entre 2 et 100 caractères.",
        'batiment'      => "Le nom du bâtiment doit contenir entre 2 et 100 caractères.",
        'capacite'      => "La capacité doit être un nombre entre 1 et 1000.",
        'type_salle_id' => "Veuillez sélectionner un type de salle valide.",
        'active'        => "Le statut actif est invalide.",
    ];

    public function validate(array $data): ValidationResult
    {
        $errors = [];

        $rules = [
            'nom' => v::key('nom', v::stringType()->length(2, 100), true),
            'batiment' => v::key('batiment', v::stringType()->length(2, 100), true),
            'capacite' => v::key('capacite', v::intVal()->between(1, 1000), true),
            'type_salle_id' => v::key('type_salle_id', v::intVal()->positive(), true),
            'active' => v::key('active', v::boolVal(), true),
        ];

        foreach ($rules as $key => $rule) {
            try {
                $rule->assert($data);
            } catch (NestedValidationException $e) {
                $errors[$key] = $this->messages[$key] ?? "Le champ '{$key}' est invalide.";
            }
        }

        if (!empty($errors)) {
            return new ValidationResult(false, $errors, []);
        }

        return new ValidationResult(true, [], $data);
    }
}