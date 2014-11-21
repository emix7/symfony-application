<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\MenuBundle\Admin;

use Endroid\Bundle\AdminBundle\Admin\BaseAdmin;
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
        $routes = $this->container->get('endroid_route.collector')->getRoutes();

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
            ->addIdentifier('label', 'string', array('label' => 'Naam', 'template' => 'EndroidMenuBundle:MenuItemAdmin:list_field_label.html.twig'))
            ->add('route', 'string', array('label' => 'Pad', 'template' => 'EndroidMenuBundle:MenuItemAdmin:list_field_path.html.twig'))
            ->add('add', 'string', array('label' => 'Subs', 'template' => 'EndroidMenuBundle:MenuItemAdmin:list_field_children.html.twig'))
        ;

        parent::configureListFields($listMapper);
    }
}
