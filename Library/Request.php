<?php

/**
 *
 * @author Rafael Arend
 *
**/

namespace Library;

class Request
{
    public readonly string $verb;
    public readonly string $uri;
    public readonly array $data;

    public function __construct()
    {
        $this->verb = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];

        if ($this->verb === 'POST') {
            $this->data = $_POST;
        } else {
            $this->data = $_GET;
        }
    }

    public function empty(): bool
    {
        return empty($this->data);
    }

    public function has(string $key): bool
    {
        return !empty($this->data[$key]);
    }

    public function notHas(string $key): bool
    {
        return empty($this->data[$key]);
    }

    public function exists(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function get(string $key): mixed
    {
        return $this->has($key) ? $this->data[$key] : null;
    }

    public function send()
    {
    }
}
