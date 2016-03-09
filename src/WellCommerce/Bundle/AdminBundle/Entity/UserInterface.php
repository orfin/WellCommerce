<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\AdminBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface UserInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserInterface extends \Serializable, EquatableInterface, BaseUserInterface, TimestampableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param string $lastName
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $username
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     */
    public function setEmail($email);

    /**
     * @param string $salt
     */
    public function setSalt($salt);

    /**
     * @inheritDoc
     */
    public function getSalt();

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $password
     */
    public function setPassword($password);

    /**
     * @return array
     */
    public function getRoles();

    /**
     * @param RoleInterface $role
     */
    public function addRole(RoleInterface $role);

    /**
     * @param Collection $roles
     */
    public function setRoles(Collection $roles);


    /**
     * @return Collection
     */
    public function getGroups();

    /**
     * @param Collection $groups
     */
    public function setGroups(Collection $groups);

    /**
     * @return bool
     */
    public function getEnabled();

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled);

    /**
     * @return string
     */
    public function getApiKey();

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey);
}
