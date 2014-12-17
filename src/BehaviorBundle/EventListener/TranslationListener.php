<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace BehaviorBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class TranslationListener extends ContainerAware
{
    /**
     * Sets target entity classes upon class meta data load.
     *
     * @param LoadClassMetadataEventArgs $args
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        /** @var ClassMetadata $classMetadata */
        $classMetadata = $args->getClassMetadata();
        $reflectionClass = new ReflectionClass($classMetadata->getName());

        // Set correct target entities
        if ($reflectionClass->implementsInterface('BehaviorBundle\Model\TranslationInterface')) {
            $classMetadata->associationMappings['translatable']['targetEntity'] = $classMetadata->getName().'Translatable';
        } elseif ($reflectionClass->implementsInterface('BehaviorBundle\Model\TranslatableInterface')) {
            $classMetadata->associationMappings['translations']['targetEntity'] = str_replace('Translatable', '', $classMetadata->getName());
        }
    }

    /**
     * Adds the locale filter in case of frontend.
     *
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        /** @var EntityManager $manager */
        $manager = $this->container->get('doctrine')->getManager();

        if (strpos($this->container->get('request')->getPathInfo(), '/admin') !== 0) {
            $filter = $manager->getFilters()->enable('translation');
            $filter->setParameter('locale', $this->container->get('request')->getLocale());
        }
    }
}
