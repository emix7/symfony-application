<?php

namespace PdfBundle\Features\Context;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Feature context.
 */
class FeatureContext extends MinkContext
{
    use KernelDictionary;

    /**
     * @Then /^I should see "([^"]*)" in the header "([^"]*)"$/
     */
    public function iShouldSeeInTheHeader($value, $header)
    {
        $header = strtolower($header);
        $headers = $this->getSession()->getResponseHeaders();

        if (!isset($headers[$header][0]) || strpos($headers[$header][0], $value) === false) {
            throw new \Exception(sprintf('Did not see header '.$header.' with value '.$value, $header, $value));
        }
    }
}
