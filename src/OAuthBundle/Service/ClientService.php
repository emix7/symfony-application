<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OAuthBundle\Service;

use Exception;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use FOS\OAuthServerBundle\Model\ClientInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientService
{
    /**
     * @var ClientManagerInterface
     */
    protected $clientManager;

    /**
     * @param $clientManager
     */
    public function __construct(ClientManagerInterface $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    /**
     * Creates a client.
     *
     * @param array $options
     *
     * @return ClientInterface
     *
     * @throws Exception
     */
    public function create(array $options = array())
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $options = $optionsResolver->resolve($options);

        $client = $this->clientManager->createClient();
        $client->setAllowedGrantTypes($options['grant_types']);
        $client->setRedirectUris($options['redirect_uris']);

        $this->clientManager->updateClient($client);

        if (!$client->getPublicId() || !$client->getSecret()) {
            throw new Exception('Could not create valid client');
        }

        return $client;
    }

    /**
     * Configures options.
     *
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'grant_types' => array('client_credentials'),
            'redirect_uris' => array(),
            'user' => null,
        ));
    }

    /**
     * Removes a client.
     *
     * @param ClientInterface $client
     */
    public function remove(ClientInterface $client)
    {
        $this->clientManager->deleteClient($client);
    }
}
