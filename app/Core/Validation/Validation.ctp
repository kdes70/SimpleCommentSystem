<?php

namespace App\Core\Validation;

use Valitron\Validator as ValitronValidator;

class Validation implements ValidationInterface
{
    public function validate(array $data, array $rules): ?array
    {
        $validator = new ValitronValidator($data);

        foreach ($rules as $field => $rulesToApply) {
            $rulesList = explode('|', $rulesToApply);

            foreach ($rulesList as $rule) {
                $validator->rule($rule, [$field]);
            }
        }

        if (!$validator->validate()) {
            return $validator->errors();
        }

        return null;
    }
}
