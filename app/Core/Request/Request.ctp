<?php

namespace App\Core\Request;

class Request
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

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getBody(): array
    {
        return $this->data;
    }
}
