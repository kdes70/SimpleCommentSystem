<?php

namespace App\Controllers;

use DI\DependencyException;
use DI\NotFoundException;

abstract class Controller
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function render(?string $template = null, array $data = []): mixed
    {
        return view($template, $data);
    }

    public function json(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
