<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\NewsBundle\Admin;

use Endroid\Bundle\AdminBundle\Admin\BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class ArticleAdmin extends BaseAdmin
{
    protected $datagridValues = array(
        '_sort_by' => 'translatable.date',
        '_sort_order' => 'DESC',
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $subject = $this->getSubject();

        $translatable = $subject->getTranslatable();
        if ($translatable->getDate() === null) {
            $translatable->setDate(new \DateTime());
        }

        $formMapper
            ->with('General')
                ->add('title')
                ->add('date', 'date', array('property_path' => 'translatable.date'))
                ->add('image', 'sonata_type_model', array('required' => false, 'property_path' => 'translatable.image', 'class' => 'Endroid\\Bundle\\MediaBundle\\Entity\\Media'))
                ->add('content', 'textarea', array(
                    'attr' => array(
                        'class' => 'tinymce',
                    ),
                )
            )
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);

        $listMapper
            ->addIdentifier('title')
            ->add('translatable.date')
        ;
    }
}
