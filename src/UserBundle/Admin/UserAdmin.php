<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UserBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\UserBundle\Admin\Model\UserAdmin as SonataUserAdmin;

class UserAdmin extends SonataUserAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $user = $this->getSubject();
        $headerService = $this->getConfigurationPool()->getContainer()->get('wsse.header_service');

        $formMapper
            ->with('API')
                ->add('apiKey', null, array('label' => 'API Key'))
                ->add('wsseHeader', 'text', array('label' => 'WSSE Header', 'mapped' => false, 'read_only' => true, 'data' => $headerService->create($user->getUsername(), $user->getApiKey())))
            ->end()
        ;
    }
}
