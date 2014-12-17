<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PageBundle\Controller;

use PageBundle\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    /**
     * @Route("/{slug}")
     * @Template()
     */
    public function showAction(Page $page)
    {
        // Disable filters to allow for language switch
        $this->container->get('doctrine')->getManager()->getFilters()->disable('publishable');
        $this->container->get('doctrine')->getManager()->getFilters()->disable('translation');

        return array(
            'page' => $page,
        );
    }
}
