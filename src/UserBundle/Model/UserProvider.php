<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UserBundle\Model;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Util\TokenGenerator;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use UserBundle\Entity\User;

class UserProvider extends FOSUBUserProvider implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Sets the entity manager.
     *
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        try {
            $user = parent::loadUserByOAuthUserResponse($response);
        } catch (AccountNotLinkedException $exception) {
            $data = $response->getResponse();
            $user = $this->userManager->findUserByEmail($data['email']);
            if (!$user) {
                $user = $this->createUser($data);
            }
            $user->setGoogleId($data['id']);
        }

        return $user;
    }

    /**
     * Creates a user based on the given response data.
     *
     * @param array $data
     *
     * @return User
     */
    protected function createUser(array $data = array())
    {
        $address = $data['email'];
        $domain = substr($address, strpos($address, '@') + 1);

        $groupNames = array();
        $whitelist = $this->container->getParameter('user.whitelist');
        foreach ($whitelist as $entry) {
            switch ($entry['type']) {
                case 'domain':
                    if ($entry['match'] == $domain) {
                        $groupNames = array_merge($groupNames, $entry['groups']);
                    }
                    break;
                case 'address':
                    if ($entry['match'] == $address) {
                        $groupNames = array_merge($groupNames, $entry['groups']);
                    }
                    break;
            }
        }

        $groupNames = array_unique($groupNames);

        if (count($groupNames) == 0) {
            throw new UnsupportedUserException('Bad credentials');
        }

        $user = new User();
        $user->setUsername($address);
        $user->setEmail($address);
        $user->setFirstName($data['given_name']);
        $user->setLastName($data['family_name']);
        $user->setEnabled(true);

        foreach ($groupNames as $groupName) {
            $group = $this->entityManager->getRepository('UserBundle:Group')->findOneByName($groupName);
            $user->addGroup($group);
        }

        /** @var TokenGenerator $tokenGenerator */
        $tokenGenerator = $this->container->get('fos_user.util.token_generator');
        $password = substr($tokenGenerator->generateToken(), 0, 8);
        $encoder = $this->container->get('security.password_encoder');
        $passwordEncoded = $encoder->encodePassword($user, $password);
        $user->setPassword($passwordEncoded);

        return $user;
    }
}
