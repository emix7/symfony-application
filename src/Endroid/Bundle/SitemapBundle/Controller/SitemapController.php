<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\SitemapBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    /**
     * @Route("/sitemap")
     * @Template()
     */
    public function indexAction()
    {
        $menus = array(
            $this->get('endroid_menu.main'),
            $this->get('endroid_menu.footer'),
        );

        return array(
            'menus' => $menus,
        );
    }

    /**
     * @Route("/sitemap.xml")
     * @Template()
     */
    public function xmlAction()
    {
        $urls = array();
        $routes = $this->get('endroid_route.collector')->getRoutes();

        foreach ($routes as $route) {
            $urls[] = $this->generateUrl($route->getName(), $route->getParameters(), true);
        }

        return new Response(
            $this->renderView("EndroidSitemapBundle:Sitemap:index.xml.twig", array('urls' => $urls)),
            200, array('Content-Type' => 'text/xml')
        );
    }
}
