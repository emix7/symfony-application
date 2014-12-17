<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PageBundle\Service;

use RouteBundle\Entity\Route;
use RouteBundle\Service\RouteProviderInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class RouteProvider extends ContainerAware implements RouteProviderInterface
{
    public function getRoutes()
    {
        $routes = array();

        $pages = $this->container->get('doctrine')->getRepository('PageBundle:Page')->findAll();

        foreach ($pages as $page) {
            $routeDetail = new Route();
            $routeDetail->setLabel($page->getTitle());
            $routeDetail->setKey('page_page_show_'.$page->getId());
            $routeDetail->setName('page_page_show');
            $routeDetail->setParameters(array('slug' => $page->getSlug()));
            $routes['page_page_show_'.$page->getId()] = $routeDetail;
        }

        return $routes;
    }
}
