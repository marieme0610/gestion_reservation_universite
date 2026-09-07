<?php

namespace App\Validation;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;


class SalleValidator implements ValidatorInterface{

    private const TYPES_AUTORISES = [
        'Amphithéâtre',
        'Salle de TP',
        'Salle de cours',
        'Bureau',
        'Salle de réunion'
    ];

    public function validate(array $data): ValidationResult{

        $errors = [];

        $rules = [
            'nom'=> v::key('nom',v::stringType()->length(2,100),true),
            'batiment'=> v::key('batiment',v::stringType()->length(2,100),true),
            'capacite'=> v::key('capacite',v::intVal()->between(1,1000),true),
            'type'=> v::key('type',v::in(self::TYPES_AUTORISES),true),
            'active'=> v::key('active',v::boolVal(),true),
        ];

        foreach ($rules as $key => $rule) {
            try {
                $rule->assert($data);
            } catch (NestedValidationException $e) {
                $errors[$key] = "Le champ '{$key}' est invalide.";
            }
        }

        if(!empty($errors)){
            return new ValidationResult(false,$errors,[]);
        }

        return new ValidationResult (true,[],$data);
    }
}