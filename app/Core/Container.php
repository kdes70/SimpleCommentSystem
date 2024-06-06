<?php

namespace App\Core;

use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Psr\Container\ContainerInterface;

class Container
{
    private static ?Container $instance = null;

    private function __construct(private readonly \DI\Container $container)
    {
    }

    /**
     * @throws \Exception
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self(self::buildContainer());
        }

        return self::$instance;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function get(string $className)
    {
        return $this->container->get($className);
    }

    /**
     * @throws \Exception
     */
    public static function buildContainer(): \DI\Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(__DIR__ . '/../../config/di.php');
        $builder->addDefinitions([
            \DI\Container::class => \DI\create(\DI\Container::class),
            Database::class => fn(ContainerInterface $c) => new Database(
                require __DIR__ . '/../../config/database.php'
            ),
        ]);
        return $builder->build();
    }
}
