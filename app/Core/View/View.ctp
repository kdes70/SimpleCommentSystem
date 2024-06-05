<?php

namespace App\Core\View;

use Slim\Views\Twig;

class View
{
    private static View $instance;
    private $twig;

    private function __construct()
    {
        $viewsDir = __DIR__ . '/../views';
        $cacheDir = __DIR__ . '/../var/cache/twig';

        $this->twig = Twig::create($viewsDir, [
            'cache' => $cacheDir,
            'debug' => true, // Установите false в production
        ]);
    }

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function render(string $template, array $data = []): string
    {
        return $this->twig->fetch($template, $data);
    }
}
