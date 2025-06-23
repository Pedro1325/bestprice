<?php

class Router
{
    private $routes = [];

    public function add($route, $controller, $method)
    {
        $this->routes[$route] = ['controller' => $controller, 'method' => $method];
    }

    public function run()
    {
        $rota = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';

        if (isset($this->routes[$rota])) {
            $controller = new $this->routes[$rota]['controller']();
            $method = $this->routes[$rota]['method'];

            $controller->$method();
                
        } else {
            http_response_code(404);
            header("Location: 404");
        }
    }
}
?>