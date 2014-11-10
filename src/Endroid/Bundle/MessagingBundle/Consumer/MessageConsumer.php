<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Bundle\MessagingBundle\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MessageConsumer implements ConsumerInterface
{
    use ContainerAwareTrait;

    /**
     * Handles the message.
     *
     * @param AMQPMessage $message
     */
    public function execute(AMQPMessage $message)
    {
        $message = json_decode($message->body, true);

        $filePath = $this->container->get('kernel')->getCacheDir().'/message.json';
        file_put_contents($filePath, json_encode($message));
    }
}
