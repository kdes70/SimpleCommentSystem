<?php

namespace App\Core\Validation;

use Valitron\Validator;

class ValidatorFactory
{
    public function make(array $roles): Validator
    {
        return new Validator($roles);
    }
}
