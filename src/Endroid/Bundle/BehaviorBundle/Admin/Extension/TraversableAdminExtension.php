<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\BehaviorBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class TraversableAdminExtension extends AdminExtension implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Handles object creation.
     *
     * @param AdminInterface $admin
     * @param mixed          $object
     */
    public function alterNewInstance(AdminInterface $admin, $object)
    {
        if ($object->getParent() == null) {
            $reflectionClass = $admin->getClass();
            $parent = $this->container->get('doctrine')->getRepository($reflectionClass)->findOneById($this->container->get('request')->query->get('parent'));

            $object->setParent($parent);
        }
    }

    /**
     * Configures form fields.
     *
     * @param FormMapper $formMapper
     */
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Traversable')
                ->add('parent')
            ->end()
        ;
    }
}
