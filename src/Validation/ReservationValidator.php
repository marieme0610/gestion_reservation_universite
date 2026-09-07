<?php

namespace App\Validation;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;


class ReservationValidator implements ValidatorInterface
{

    public function validate(array $data): ValidationResult
    {
        $errors = [];
        $rules = [
            'salle_id'              => v::key('salle_id', v::intVal()->positive(), true),
            'responsable'           => v::key('responsable', v::stringType()->length(2, 120), true),
            'motif'                 => v::key('motif', v::stringType()->length(5, 255), false),
            'email'                 => v::key('email', v::email(), true),
            'date_debut'            => v::key('date_debut', v::dateTime(), true),
            'date_fin'              => v::key('date_fin', v::dateTime(), true),
        ];

        foreach ($rules as $key => $rule) {
            try {
                $rule->assert($data);
            } catch (NestedValidationException $e) {
                $errors[$key] = "Le champ '{$key}' est invalide.";
            }
        }

        if (!empty($errors)) {
            return new ValidationResult(false, $errors, []);
        }

        return new ValidationResult(true, [], $data);
    }
}
