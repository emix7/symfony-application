<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace BehaviorBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class PublishableListener extends ContainerAware
{
    /**
     * Adds the locale filter in case of frontend.
     *
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $manager = $this->container->get('doctrine')->getManager();

        if (strpos($this->container->get('request')->getPathInfo(), '/admin') !== 0) {
            $manager->getFilters()->enable('publishable');
        }
    }
}
