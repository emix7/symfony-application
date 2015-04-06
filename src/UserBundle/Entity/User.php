<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use OAuthBundle\Entity\Client;
use Sonata\UserBundle\Entity\BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $apiKey;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $googleId;

    /**
     * @ORM\OneToMany(targetEntity="OAuthBundle\Entity\Client", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $clients;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->clients = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the API key.
     *
     * @param $apiKey
     *
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Returns the Google ID.
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Sets the Google ID.
     *
     * @param $googleId
     *
     * @return $this
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Returns the API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Checks if the user has a specific client.
     *
     * @param Client $client
     *
     * @return bool
     */
    public function hasClient(Client $client)
    {
        return $this->clients->contains($client);
    }

    /**
     * Adds an OAuth client.
     *
     * @param Client $client
     *
     * @return User
     */
    public function addClient(Client $client)
    {
        $this->clients->add($client);

        if (!$client->getUser() == $this) {
            $client->setUser($this);
        }

        return $this;
    }

    /**
     * Returns all OAuth clients.
     *
     * @return ArrayCollection
     */
    public function getClients()
    {
        return $this->clients;
    }
}
