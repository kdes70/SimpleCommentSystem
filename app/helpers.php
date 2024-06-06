<?php

use App\Core\Container;
use App\Core\View\ViewFactory;

if (!function_exists('view')) {
    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    function view(?string $template = null, array $data = []): mixed
    {
        $container = Container::getInstance();
        $factory = $container->get(ViewFactory::class);
        $view = $factory->make();

        if ($template) {
            return $view->render($template, $data);
        }

        return $view;
    }
}
