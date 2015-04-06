<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UserBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use UserBundle\Entity\User;

class UserListener
{
    /**
     * {@inheritdoc}
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof User && !$entity->getApiKey()) {
            $entity->setApiKey(md5(uniqid('', true)));
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }
}
