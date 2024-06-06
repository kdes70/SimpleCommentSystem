<?php

namespace App\Core\View;

class ViewFactory
{
    protected TemplateEngineInterface $templateEngine;

    public function __construct(TemplateEngineInterface $templateEngine) {
        $this->templateEngine = $templateEngine;
    }

    public function make(): View
    {
        return new View($this->templateEngine);
    }
}
