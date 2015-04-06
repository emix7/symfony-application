<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OAuthBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_client")
 */
class Client extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="clients", cascade={"persist", "remove"})
     */
    protected $user;

    /**
     * Sets the user.
     *
     * @param $user
     *
     * @return Client
     */
    public function setUser(User $user)
    {
        if (!$user->hasClient($this)) {
            $user->addClient($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * Returns the client.
     */
    public function getUser()
    {
        return $this->user;
    }
}
