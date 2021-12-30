<?php

/**
 *
 * @author Rafael Arend
 *
**/

namespace Library;

use Exception;

class Router
{
    private array $enabledVerbs = ['POST', 'GET'];
    private array $routes = [];
    private Request $request;
    private array $action = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function addRoute(string $verb, string $route, string $controller, string $method = null): void
    {
        if (!in_array($verb, $this->enabledVerbs, true)) {
            throw new Exception('Verbo '.$verb.' nao suportado');
        }

        $this->routes[$verb][$route] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function parseRoutes(): void
    {
        $verb = $this->request->verb;
        $uri = $this->request->uri;

        array_walk($this->routes[$verb], function ($value, $key) use ($uri) {
            if ($uri === $key) {
                $this->action = $value;
            }
        });

        if (!$this->action) {
            throw new Exception('Rota '.$verb.' '.$uri.' nao existe');
        }
    }

    public function dispatch(): void
    {
        $controller = new $this->action['controller'];
        $controller->{$this->action['method']}($this->request);
    }
}
