<?php

namespace Endroid\Bundle\SiteBundle\Features\Context;

use Endroid\Bundle\OAuthBundle\Command\CreateClientCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Feature context.
 */
class FeatureContext extends RawMinkContext implements KernelAwareInterface
{
    private $kernel;
    private $parameters;

    protected $clientId;
    protected $clientSecret;
    protected $accessToken;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^I am on "([^"]*)"$/
     */
    public function iAmOn($path)
    {
        $this->getSession()->visit($path);
    }

    /**
     * @Then /^I should see "([^"]*)"$/
     */
    public function iShouldSee($string)
    {
        $this->assertSession()->responseContains($string);
    }

    /**
     * @Given /^I create a client id and secret$/
     */
    public function iCreateAClientIdAndSecret()
    {
        $command = new CreateClientCommand();
        $command->setContainer($this->kernel->getContainer());
        $input = new ArrayInput(array('--grant-type' => array('client_credentials')));
        $output = new BufferedOutput();
        $command->run($input, $output);

        $result = $output->fetch();

        $this->clientId = preg_replace('#.*Client ID: ([0-9]+_[a-z0-9]+).*#is', '$1', $result);
        $this->clientSecret = preg_replace('#.*Client secret: ([a-z0-9]+).*#is', '$1', $result);

        if (!$this->clientId || !$this->clientSecret) {
            throw new \Exception('No valid client id and / or secret returned');
        }
    }

    /**
     * @Given /^I retrieve an access token$/
     */
    public function iRetrieveAnAccessToken()
    {
        $this->getSession()->visit('/oauth/v2/token?client_id='.$this->clientId.'&client_secret='.$this->clientSecret.'&grant_type=client_credentials');

        $response = $this->getSession()->getPage()->getContent();
        $json = json_decode($response);

        if (!$json || !$json->access_token) {
            throw new \Exception('No valid JSON returned');
        }

        $this->accessToken = $json->access_token;
    }

    /**
     * @Then /^I should be able to perform an API call$/
     */
    public function iShouldBeAbleToPerformAnApiCall()
    {
        $this->getSession()->visit('/api/pages/1.json?access_token='.$this->accessToken);

        $response = $this->getSession()->getPage()->getContent();
        $json = json_decode($response);

        if (!$json || (isset($json->error) && $json->error == 'invalid_grant')) {
            throw new \Exception('Invalid grant');
        }
    }
}
