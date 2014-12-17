<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UserBundle\Model;

use UserBundle\Entity\User;
use FOS\UserBundle\Entity\UserManager as FOSUserManager;
use FOS\UserBundle\Util\TokenGenerator;
use Fp\OpenIdBundle\Security\Core\User\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserManager extends FOSUserManager implements UserManagerInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Creates a new user from the OpenID login.
     *
     * @param  string                   $identity
     * @param  array                    $attributes
     * @return UserInterface
     * @throws UnsupportedUserException
     */
    public function createUserFromIdentity($identity, array $attributes = array())
    {
        $user = $this->em->getRepository('UserBundle:User')->findOneByEmail($attributes['contact/email']);

        if ($user) {
            return $user;
        }

        $address = $attributes['contact/email'];
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
        $user->setFirstName($attributes['namePerson/first']);
        $user->setLastName($attributes['namePerson/last']);
        $user->setEnabled(true);

        foreach ($groupNames as $groupName) {
            $group = $this->em->getRepository('UserBundle:Group')->findOneByName($groupName);
            $user->addGroup($group);
        }

        /** @var TokenGenerator $tokenGenerator */
        $tokenGenerator = $this->container->get('fos_user.util.token_generator');
        $password = substr($tokenGenerator->generateToken(), 0, 8);
        $user->setPlainPassword($password);

        $this->updatePassword($user);

        return $user;
    }
}
