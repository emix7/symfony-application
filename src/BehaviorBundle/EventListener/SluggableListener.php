<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace BehaviorBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Gedmo\Sluggable\Util\Urlizer;
use BehaviorBundle\Model\SluggableInterface;

class SluggableListener
{
    /**
     * Handles behavior logic before persisting entity.
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof SluggableInterface) {
            $slug = Urlizer::urlize($entity->getSluggable());
            $entity->setSlug($slug);
        }
    }
}
