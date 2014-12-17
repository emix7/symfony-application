<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SitemapBundle\Service;

use RouteBundle\Entity\Route;
use RouteBundle\Service\RouteProviderInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class RouteProvider extends ContainerAware implements RouteProviderInterface
{
    public function getRoutes()
    {
        $routes = array();

        $routeHome = new Route();
        $routeHome->setLabel('Sitemap');
        $routeHome->setKey('sitemap_sitemap_index');
        $routeHome->setName('sitemap_sitemap_index');
        $routes['sitemap_sitemap_index'] = $routeHome;

        return $routes;
    }
}
