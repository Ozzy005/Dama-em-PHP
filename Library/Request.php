<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Library;

class Request
{
    private array $headers = [];
    private array $data;
    public readonly string $uri;

    public function __construct()
    {
        $this->setHeaders();
        $this->setUri();
        $this->setData();
    }

    private function setHeaders(): void
    {
        foreach ($_SERVER as $key => $value) {
            $explode = explode('_', $key);
            $keyFormated = '';

            foreach ($explode as $key => $chunk) {
                if (!$key) {
                    $keyFormated = strtolower($explode[$key]);
                } else {
                    $keyFormated .= ucfirst(strtolower($explode[$key]));
                }
            }

            $this->headers[$keyFormated] = $value;
        }
    }

    private function setUri(): void
    {
        $uri = $this->requestUri;
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $this->uri = rawurldecode($uri);
    }

    private function setData(): void
    {
        if ($this->requestMethod === 'POST') {
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
        return key_exists($key, $this->data);
    }

    public function get(string $key): string|bool
    {
        return $this->exists($key) ? $this->data[$key] : false;
    }

    public function __get(string $name): string|bool
    {
        return key_exists($name, $this->headers) ? $this->headers[$name] : false;
    }
}
