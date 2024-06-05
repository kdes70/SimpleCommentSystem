<?php

namespace App\Core\Request;

use App\Core\Validator;

class RequestForm extends Request
{
    public function validate(array $rules): array
    {
        return (new Validator())->validate($rules, $this->getBody());
    }
}
