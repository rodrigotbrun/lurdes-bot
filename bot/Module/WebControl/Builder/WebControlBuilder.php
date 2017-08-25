<?php

namespace LurdesBot\WebControl\Builder;

use Slim\App;
use Slim\Exception\NotFoundException;

class WebControlBuilder extends App {

    private $injectionMapDirectory;
    private $availableMethods = ['POST', 'GET', 'PUT', 'DELETE', 'OPTIONS', '*'];

    /**
     * WebControlBuilder constructor.
     */
    public function __construct() {
        parent::__construct([
            'settings' => [
                'displayErrorDetails' => true,
                'addContentLengthHeader' => false,
            ]
        ]);

        $this->injectionMapDirectory = __DIR__ . '/../Injection/';
        $this->configureInject();
    }

    private function configureInject() {
        $container = $this->getContainer();
        $injectionFiles = scandir($this->injectionMapDirectory);
        unset($injectionFiles[0]);
        unset($injectionFiles[1]);

        foreach ($injectionFiles as $inject) {
            $injectionName = explode('.', $inject);
            $injectionName = reset($injectionName);

            $container[$injectionName] = require_once "{$this->injectionMapDirectory}{$inject}";
        }
    }

    public function registerRoutes() {
        $routesFile = www_path('routes.php');
        if (file_exists($routesFile)) {
            $routes = require $routesFile;
            if (is_array($routes) && count($routes) > 0) {

                foreach ($routes as $endpoint => $route) {
                    if (!isset($route['method'])) $route['method'] = 'GET';
                    $method = strtoupper($route['method']);

                    if (in_array($method, $this->availableMethods)) {
                        if ($method === '*') $method = 'any';
                        $method = strtolower($method);
                        if (!isset($route['controller'])) throw new \Exception('Controller not found!');

                        $definedRoute = $this->$method($endpoint, $route['controller']);

                        if (isset($route['name']) && !empty(trim($route['name'])))
                            $definedRoute->setName($route['name']);

                    } else {
                        throw new \Exception('HTTP Method not allowed!');
                    }
                }

            }
        }
    }

}