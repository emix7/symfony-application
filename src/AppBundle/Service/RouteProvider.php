<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Service;

use RouteBundle\Entity\Route;
use RouteBundle\Service\RouteProviderInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class RouteProvider extends ContainerAware implements RouteProviderInterface
{
    public function getRoutes()
    {
        $routes = array();

        $routeHome = new Route();
        $routeHome->setLabel('Home');
        $routeHome->setKey('app_home_index');
        $routeHome->setName('app_home_index');
        $routes['app_home_index'] = $routeHome;

        return $routes;
    }
}
