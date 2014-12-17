<?php

namespace AppBundle\Features\Context;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Feature context.
 */
class FeatureContext extends MinkContext
{
    use KernelDictionary;
}
