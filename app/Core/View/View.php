<?php

namespace App\Core\View;

class View implements TemplateEngineInterface
{
    public function __construct(protected TemplateEngineInterface $templateEngine)
    {
    }

    public function render(string $template, array $data = []): string
    {
        echo $this->templateEngine->render($template, $data);
    }
}
