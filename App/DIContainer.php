<?php

namespace App;

class DIContainer
{
    private array $services = [];

    public function set(string $name, callable $resolver): void
    {
        $this->services[$name] = $resolver;
    }

    public function get(string $name)
    {
        if (!isset($this->services[$name])) {
            throw new \Exception("Service not found: " . $name);
        }
        return $this->services[$name]($this);
    }
}
