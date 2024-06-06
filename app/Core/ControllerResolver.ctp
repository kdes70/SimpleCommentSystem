<?php

namespace App\Core;

use DI\DependencyException;
use DI\NotFoundException;

readonly class ControllerResolver
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function resolve(string $handler): ControllerContract
    {
        $container = Container::getInstance();

        [$controllerClass] = explode('@', $handler, 2);

        return $container->get($controllerClass);
    }
}
