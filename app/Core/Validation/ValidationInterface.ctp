<?php

namespace App\Core\Validation;

interface ValidationInterface
{
    public function validate(array $data, array $rules): ?array;
}
