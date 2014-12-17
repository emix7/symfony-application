<?php

namespace MessagingBundle\Features\Context;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Feature context.
 */
class FeatureContext extends MinkContext
{
    use KernelDictionary;

    /**
     * @Then /^I should find a file "([^"]*)" in the cache folder$/
     */
    public function iShouldFindAFileInTheCacheFolder($fileName)
    {
        sleep(10);

        $filePath = $this->kernel->getCacheDir().'/'.$fileName;

        if (!file_exists($filePath)) {
            throw new \Exception('File '.$fileName.' not found in cache folder');
        }
    }
}
