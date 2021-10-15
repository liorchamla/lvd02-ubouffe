<?php

namespace App\Container;

use ReflectionClass;
use RuntimeException;

class Container
{
    private array $factories = [];
    private array $instances = [];

    public function set(string $className, callable $factory)
    {
        $this->factories[$className] = $factory;
    }

    public function get(string $className)
    {
        if (!empty($this->instances[$className])) {
            return $this->instances[$className];
        }

        if (empty($this->factories[$className])) {
            // throw new RuntimeException("Impossible de construire un objet de la classe $className, essayez de configurer le Container d'abord grâce à la méthode set()");

            // Je vais essayer d'analyser ta class et on va voir ce qu'on peut faire
            $reflectionClass = new ReflectionClass($className);
            $constructor = $reflectionClass->getConstructor();
            $params = $constructor->getParameters();

            $arguments = [];

            foreach ($params as $param) {
                $dependency = $this->get($param->getType()->getName());
                $arguments[] = $dependency;
            }

            return $reflectionClass->newInstanceArgs($arguments);
        }

        $factory = $this->factories[$className];

        $instance = $factory($this);

        $this->instances[$className] = $instance;

        return $instance;
    }
}
