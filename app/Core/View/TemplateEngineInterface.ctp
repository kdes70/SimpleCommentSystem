<?php

namespace App\Core\View;

interface TemplateEngineInterface
{
    public function render(string $template, array $data = []): string;
}
