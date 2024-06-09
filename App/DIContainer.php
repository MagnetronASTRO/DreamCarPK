<?php

namespace App;

use ReflectionClass;
use ReflectionNamedType;

class DIContainer
{
    private array $instances = [];
    private array $bindings = [];
    private array $singletons = [];

    public function get(string $class)
    {
        if (isset($this->singletons[$class])) {
            return $this->singletons[$class];
        }

        if (!isset($this->instances[$class])) {
            $this->instances[$class] = $this->resolve($class);
        }

        return $this->instances[$class];
    }

    public function bind(string $abstract, string $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function singleton(string $abstract, $instance): void
    {
        $this->singletons[$abstract] = $instance;
    }

    private function resolve(string $class)
    {
        if (isset($this->bindings[$class])) {
            $class = $this->bindings[$class];
        }

        if (isset($this->singletons[$class])) {
            return $this->singletons[$class];
        }

        $reflector = new ReflectionClass($class);

        if (!$reflector->isInstantiable()) {
            throw new \Exception("Class {$class} is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $class;
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType();

            if ($dependency instanceof ReflectionNamedType && !$dependency->isBuiltin()) {
                $dependencies[] = $this->get($dependency->getName());
            } else {
                $dependencies[] = $this->resolveNonClass($parameter);
            }
        }

        return $reflector->newInstanceArgs($dependencies);
    }

    private function resolveNonClass(\ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new \Exception("Cannot resolve the parameter {$parameter->name}");
    }
}
