<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\MessagingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $message = array(
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3'
        );

        $json = json_encode($message);

        $this->get('old_sound_rabbit_mq.message_producer')
            ->setContentType('application/json')
            ->publish($json);

        return new JsonResponse($message);
    }
}
