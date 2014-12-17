<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MenuBundle\Twig\Extension;

use Twig_Extension;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MenuExtension extends Twig_Extension implements ContainerAwareInterface
{
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('route', array($this, 'route')),
        );
    }

    public function route($key)
    {
        $route = $this->container->get('route.collector')->getRouteByKey($key);

        return $route;
    }

    public function getName()
    {
        return 'menu_extension';
    }
}
