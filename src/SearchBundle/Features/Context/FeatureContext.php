<?php

namespace SearchBundle\Features\Context;

use AppBundle\Features\Context\FeatureContext as AppFeatureContext;

/**
 * Feature context.
 */
class FeatureContext extends AppFeatureContext
{
    use KernelDictionary;
}
