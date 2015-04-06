<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MenuBundle\Admin;

use AdminBundle\Admin\BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class MenuAdmin extends BaseAdmin
{
    protected $datagridValues = array(
        '_sort_by' => 'position',
        '_sort_order' => 'ASC',
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $routes = $this->container->get('route.collector')->getRoutes();

        $routeChoices = array();
        foreach ($routes as $route) {
            $routeChoices[$route->getKey()] = $route->getLabel();
        }

        $formMapper
            ->with('General')
                ->add('routeKey', 'choice', array('choices' => $routeChoices, 'required' => false))
                ->add('tag')
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('edit', 'string', array('label' => 'Edit', 'template' => 'MenuBundle:MenuItemAdmin:list_field_edit.html.twig'))
            ->add('path', 'string', array('label' => 'Path', 'template' => 'MenuBundle:MenuItemAdmin:list_field_path.html.twig'))
        ;

        parent::configureListFields($listMapper);
    }
}
