<?php

namespace App\core;

abstract class Request
{
    protected array $data;

    public function __construct()
    {
        $this->data = array_merge($_GET, $_POST);
        $this->sanitize();
    }

    private function sanitize(): void
    {
        array_walk_recursive($this->data, fn(&$input) => htmlspecialchars(stripslashes(trim($input))));
    }

    public function all(): array
    {
        return $this->data;
    }

    abstract public function validate(array $rules): array;
}