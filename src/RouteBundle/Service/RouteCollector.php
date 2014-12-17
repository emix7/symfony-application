<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace RouteBundle\Service;

class RouteCollector
{
    protected $providers;

    protected $routes;

    protected $routesLoaded = false;

    public function __construct()
    {
        $this->providers = array();
        $this->routes = array();
    }

    public function addProvider(RouteProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    public function loadRoutes()
    {
        if (!$this->routesLoaded) {
            foreach ($this->providers as $provider) {
                $this->routes = array_merge($this->routes, $provider->getRoutes());
            }
            $this->routesLoaded = true;
        }
    }

    public function getRoutes()
    {
        $this->loadRoutes();

        return $this->routes;
    }

    public function getRouteByKey($key)
    {
        $this->loadRoutes();

        if (!array_key_exists($key, $this->routes)) {
            return;
        }

        return $this->routes[$key];
    }
}
