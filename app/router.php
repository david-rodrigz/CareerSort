<?php

class Router {
    protected $routes = []; // stores routes

    // addRoute() method to accept route with middleware
    public function addRoute(string $method, string $url, closure $middleware = null, closure $target) {
        $this->routes[$method][$url] = ['target' => $target, 'middleware' => $middleware];
    }

    public function matchRoute() {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $route) {
                $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);
                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY); // Only keep named subpattern matches
                    if ($route['middleware']) {
                        call_user_func_array($route['middleware'], $params);
                    }
                    call_user_func_array($route['target'], $params);
                    return;
                }
            }
        }
        echo "404 Not Found";
    }
}