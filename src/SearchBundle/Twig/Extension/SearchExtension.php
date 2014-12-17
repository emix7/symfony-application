<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SearchBundle\Twig\Extension;

use Twig_Extension;

class SearchExtension extends Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('class', array($this, 'classFilter')),
        );
    }

    public function classFilter($object)
    {
        return get_class($object);
    }

    public function getName()
    {
        return 'search_extension';
    }
}
