<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace BehaviorBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class SortableAdminExtension extends AdminExtension
{
    /**
     * Configure the list fields for the current admin.
     *
     * @param $listMapper
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('up', 'string', array('label' => ' ', 'template' => 'BehaviorBundle:Sortable:list_field_up.html.twig'))
            ->add('down', 'string', array('label' => ' ', 'template' => 'BehaviorBundle:Sortable:list_field_down.html.twig'))
        ;
    }

    /**
     * Configure the default routes for the current admin.
     *
     * @param AdminInterface  $admin
     * @param RouteCollection $collection
     */
    public function configureRoutes(AdminInterface $admin, RouteCollection $collection)
    {
        $collection
            ->add('up', $admin->getRouterIdParameter().'/up')
            ->add('down', $admin->getRouterIdParameter().'/down');
    }

    public function createQuery()
    {
    }
}
