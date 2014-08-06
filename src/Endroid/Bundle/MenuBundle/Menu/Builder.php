<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;

class Builder extends ContainerAware
{
    protected $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Returns the menu with the given tag.
     *
     * @param $tag
     * @param  Request       $request
     * @return ItemInterface
     */
    public function createMenu($tag, Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->setCurrent($request->getRequestUri());

        $menuItem = $this->container->get('doctrine')->getRepository('EndroidMenuBundle:MenuItem')->findOneByTag($tag);

        foreach ($menuItem->getChildren() as $child) {
            $childRoute = $this->container->get('endroid_route.collector')->getRouteByKey($child->getRouteKey());
            if ($childRoute === null) {
                continue;
            }
            $menu->addChild($childRoute->getLabel(), array(
                'route' => $childRoute->getName(),
                'routeParameters' => $childRoute->getParameters() + array('_locale' => $this->container->get('request')->getLocale())
            ));
        }

        return $menu;
    }

    /**
     * Returns the main menu.
     *
     * @param  Request       $request
     * @return ItemInterface
     */
    public function createMenuMain(Request $request)
    {
        return $this->createMenu(($this->container->get('request')->getLocale() == 'nl') ? 'Hoofdmenu' : 'Main menu', $request);
    }

    /**
     * Returns the footer menu.
     *
     * @param  Request       $request
     * @return ItemInterface
     */
    public function createMenuFooter(Request $request)
    {
        return $this->createMenu(($this->container->get('request')->getLocale() == 'nl') ? 'Footermenu' : 'Footer menu', $request);
    }
}
