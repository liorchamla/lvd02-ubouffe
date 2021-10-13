<?php

namespace App\Http;

class Request {
    private array $params;

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    public function getParams(): array {
        return $this->params;
    }

    public function getParam(string $name): ?string {
        return $this->params[$name] ?? null;
    }
}