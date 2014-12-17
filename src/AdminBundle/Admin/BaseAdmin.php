<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AdminBundle\Admin;

use ReflectionClass;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class BaseAdmin extends Admin implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct($code, $class, $baseControllerName)
    {
        parent::_construct($code, $class, $baseControllerName);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
    }

    /**
     * Returns the persistent parameters.
     *
     * @return array
     */
    public function getPersistentParameters()
    {
        $parameters = array();

        // If no request is made don't add behavioral parameters
        if (!$this->getRequest()) {
            return $parameters;
        }

        $reflectionClass = new ReflectionClass($this->getClass());

        // Add parent to traversable urls
        if ($reflectionClass->implementsInterface('BehaviorBundle\Model\TraversableInterface')) {
            $parameters['parent'] = $this->getRequest()->query->get('parent');
        }

        // Add locale to translation urls
        if ($reflectionClass->implementsInterface('BehaviorBundle\Model\TranslationInterface')) {
            $parameters['locale'] = $this->getRequest()->query->get('locale', $this->container->getParameter('locale'));
        }

        return $parameters;
    }

    /**
     * Creates the query used to retrieve the list.
     *
     * @param  string              $context
     * @return ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $reflectionClass = new ReflectionClass($this->getClass());

        // Filter the traversable list by query string parent
        if ($reflectionClass->implementsInterface('BehaviorBundle\Model\TraversableInterface')) {
            $parentId = intval($this->container->get('request')->query->get('parent', 0));
            $query->andWhere($query->getRootAlias().'.parent '.($parentId ? '= '.$parentId : 'IS NULL'));
        }

        // Filter the translatable list by query string parent
        if ($reflectionClass->implementsInterface('BehaviorBundle\Model\TranslationInterface')) {
            $locale = $this->container->get('request')->query->get('locale', $this->container->getParameter('locale'));
            $query->andWhere($query->getRootAlias().'.locale = \''.$locale.'\'');
        }

        return $query;
    }
}
