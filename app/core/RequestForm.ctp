<?php

namespace App\core;

class RequestForm extends Request
{
    private array $errors = [];

    public function validate(array $rules): array
    {
        foreach ($rules as $field => $rule) {
            $this->validateByRule($field, $rule);
        }

        if (!empty($this->errors)) {
            return ['status' => 'error', 'errors' => $this->errors];
        }

        return array_merge(['status' => 'success'], $this->data);
    }

    private function required($value): bool
    {
        return !empty($value);
    }

    private function string($value): bool
    {
        return is_string($value);
    }

    private function email($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function max($value, $param): bool
    {
        return strlen($value) <= (int)$param;
    }

    private function validateByRule(string $field, string $rule): void
    {
        $rulesArray = explode('|', $rule);

        foreach ($rulesArray as $r) {
            $params = explode(':', $r);
            $method = $params[0];
            $param = $params[1] ?? null;

            if (method_exists($this, $method) && !$this->{$method}($this->data[$field] ?? null, $param)) {
                $this->errors[$field][] = "Field {$field} failed validation {$method}";
            }
        }
    }
}