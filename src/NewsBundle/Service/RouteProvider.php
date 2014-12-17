<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Service;

use RouteBundle\Entity\Route;
use RouteBundle\Service\RouteProviderInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class RouteProvider extends ContainerAware implements RouteProviderInterface
{
    public function getRoutes()
    {
        $routes = array();

        $articles = $this->container->get('doctrine')->getRepository('NewsBundle:Article')->findAll();

        $routeList = new Route();
        $routeList->setLabel(($this->container->get('request')->getLocale() == 'nl') ? 'Nieuws' : 'News');
        $routeList->setKey('news_article_index');
        $routeList->setName('news_article_index');
        $routes['news_article_index'] = $routeList;

        foreach ($articles as $article) {
            $routeDetail = new Route();
            $routeDetail->setLabel($article->getTitle());
            $routeDetail->setKey('news_article_show_'.$article->getId());
            $routeDetail->setName('news_article_show');
            $routeDetail->setParameters(array('slug' => $article->getSlug()));
            $routes['news_article_show_'.$article->getId()] = $routeDetail;
        }

        return $routes;
    }
}
