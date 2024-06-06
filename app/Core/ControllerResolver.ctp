<?php

namespace App\Core;

use DI\DependencyException;
use DI\NotFoundException;
use DI\Container;

readonly class ControllerResolver
{
    public function __construct(private Container $container)
    {
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function resolve(string $handler): ControllerContract
    {
        [$controllerClass] = explode('@', $handler, 2);

        return $this->container->get($controllerClass);
    }
}
