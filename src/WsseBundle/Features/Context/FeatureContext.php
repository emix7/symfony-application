<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WsseBundle\Features\Context;

use AppBundle\Features\Context\FeatureContext as AppContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\ORM\EntityManager;
use UserBundle\Entity\User;

class FeatureContext extends AppContext
{
    use KernelDictionary;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @Given /^I am an API user$/
     */
    public function iAmAnApiUser()
    {
        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /* @var User $user */
        $this->user = $manager->getRepository('UserBundle:User')->findOneByUsername('superadmin');
    }

    /**
     * @Given /^I have an invalid API key$/
     */
    public function iHaveAnInvalidApiKey()
    {
        $this->apiKey = 'invalid_api_key';
    }

    /**
     * @Given /^I have a valid API key$/
     */
    public function iHaveAValidAccessToken()
    {
        $this->apiKey = $this->user->getApiKey();
    }

    /**
     * @When /^I set the authorization header$/
     */
    public function iSetTheAuthorizationHeader()
    {
        $wsseHeaderService = $this->get('wsse.header_service');
        $wsseHeader = $wsseHeaderService->create($this->user->getUsername(), $this->apiKey);

        $this->getSession()->setRequestHeader('X-WSSE', $wsseHeader);
    }
}
