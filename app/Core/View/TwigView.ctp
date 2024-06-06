<?php

namespace App\Core\View;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class TwigView implements TemplateEngineInterface {
    protected Environment $twig;

    public function __construct(string $templatesPath) {
        $loader = new FilesystemLoader($templatesPath);
        $this->twig = new Environment($loader);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function render(string $template, array $data = []): string {
        return $this->twig->render($template, $data);
    }
}
