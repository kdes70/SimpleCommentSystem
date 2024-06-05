<?php

namespace App\Core;

use DI\ContainerBuilder;

class Container
{
    private static ?\DI\Container $instance = null;

    public static function getInstance(): \DI\Container
    {
        if (self::$instance === null) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions(__DIR__ . '/../config/di.php');
            self::$instance = $builder->build();
        }
        return self::$instance;
    }
}
