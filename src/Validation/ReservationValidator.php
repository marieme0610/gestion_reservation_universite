<?php

namespace App\Validation;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class ReservationValidator implements ReservationValidatorInterface
{
    private array $messages = [
        'salle_id'    => "Veuillez sélectionner une salle valide.",
        'responsable' => "Le nom du responsable doit contenir entre 2 et 120 caractères.",
        'motif'       => "Le motif doit contenir entre 5 et 255 caractères.",
        'email'       => "L'adresse email n'est pas valide.",
        'date_debut'  => "La date de début n'est pas une date valide.",
        'date_fin'    => "La date de fin n'est pas une date valide.",
    ];

    public function validate(array $data): ValidationResult
    {
        $errors = [];
        $rules = [
            'salle_id'              => v::key('salle_id', v::intVal()->positive(), true),
            'responsable'           => v::key('responsable', v::stringType()->length(2, 120), true),
            'motif'                 => v::key('motif', v::stringType()->length(5, 255), true),
            'email'                 => v::key('email', v::email(), true),
            'date_debut'            => v::key('date_debut', v::dateTime(), true),
            'date_fin'              => v::key('date_fin', v::dateTime(), true),
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