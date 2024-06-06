<?php

namespace App\Core\Request;

use App\Core\Validation\ValidatorFactory;
use Valitron\Validator;

class RequestForm extends Request
{
    public function validate(array $rules): Validator
    {
        return (new ValidatorFactory)->make($rules);
    }
}
