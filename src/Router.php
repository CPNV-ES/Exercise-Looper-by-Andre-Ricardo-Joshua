<?php

namespace App;

class Router
{
    private array $dependencies = []; // Reserved for a future dependency injection container.
    private array $routes = [];

    /**
     * Adds a new route to the routing table.
     */
    public function add(string $route, string $method, array $handler): void
    {
        $this->routes[] = [
            'path' => $route,
            'method' => $method,
            'handler' => $handler,
        ];
    }

    /**
     * Dispatches the request to the appropriate route handler.
     *
     * @param string $route The requested URI.
     * @param string $method The HTTP method.
     * @return array The rendering options for the view.
     * @throws \Exception If a matched route has an invalid handler configuration.
     */
    public function dispatch(string $route, string $method): array
    {
        foreach ($this->routes as $r) {
            // Convert route path to a regex pattern
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $r['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $route, $matches) && $r['method'] === $method) {
                // Validate that the handler is a valid [class, method] array.
                if (!is_array($r['handler']) || count($r['handler']) !== 2 || !class_exists($r['handler'][0]) || !method_exists($r['handler'][0], $r['handler'][1])) {
                    throw new \Exception("Invalid handler for route: {$method} {$route}");
                }

                [$controllerClass, $controllerMethod] = $r['handler'];
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $controller = new $controllerClass(/* In the future, dependencies would be injected here */);
                $result = $controller->$controllerMethod(...$params);

                if (isset($result['redirect'])) {
                    header('Location: ' . $result['redirect']);
                    exit();
                }

                return $result;
            }
        }

        // If no route is found, return a 404 response.
        return ['status_code' => 404, 'data' => ['title' => '404 Not Found']];
    }
}